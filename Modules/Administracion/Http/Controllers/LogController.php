<?php

namespace Modules\Administracion\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Import the base controller
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Spatie\Activitylog\Models\Activity; // Assuming you're using spatie/laravel-activitylog
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class LogController extends Controller
{
    /**
     * Central dashboard for all log types
     *
     * This method displays a dashboard with summaries of different log types,
     * including recent activity, error counts, and login statistics. It serves
     * as a central hub for system monitoring and troubleshooting.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Verify permissions
        if (!Auth::user()->can('logs.view')) {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes permisos para ver los registros del sistema');
        }

        // Get counts for each log type
        $activityCount = Activity::count();

        // Count system logs by parsing log files
        $logFiles = $this->getLogFiles();
        $logFilesCount = count($logFiles);

        // Get recent errors count (last 7 days)
        $recentErrorsCount = Activity::where('description', 'like', 'error%')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        // Get total system errors from the laravel log files
        $systemErrorsCount = $this->countSystemErrors();

        // Get login attempts (successful and failed)
        $loginSuccessCount = DB::table('login_activities')
            ->where('succeeded', true)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        $loginFailureCount = DB::table('login_activities')
            ->where('succeeded', false)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        // Get recent activities (last 5)
        $recentActivities = Activity::with('causer')
            ->latest()
            ->limit(5)
            ->get();

        // Get recent errors (last 5)
        $recentErrors = Activity::with('causer')
            ->where('description', 'like', 'error%')
            ->latest()
            ->limit(5)
            ->get();

        // Get log storage size
        $logStorageSize = $this->getLogStorageSize();

        return view('administracion.logs.index', compact(
            'activityCount',
            'logFilesCount',
            'recentErrorsCount',
            'systemErrorsCount',
            'loginSuccessCount',
            'loginFailureCount',
            'recentActivities',
            'recentErrors',
            'logStorageSize'
        ));
    }

    /**
     * Shows user activity logs
     *
     * This method displays activity logs generated by users in the system,
     * with optional filtering by user, action type, and date range.
     * The activity logs help track what users are doing in the system.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function activity(Request $request)
    {
        // Verify permissions
        if (!Auth::user()->can('logs.view.activity')) {
            return redirect()->route('administracion.logs.index')
                ->with('error', 'No tienes permisos para ver los registros de actividad');
        }

        $query = Activity::with('causer');

        // Apply filters if provided
        if ($request->has('user_id') && $request->user_id) {
            $query->where('causer_id', $request->user_id);
        }

        if ($request->has('action') && $request->action) {
            $query->where('description', $request->action);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->where('created_at', '>=', Carbon::parse($request->date_from)->startOfDay());
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->where('created_at', '<=', Carbon::parse($request->date_to)->endOfDay());
        }

        // Get unique action types for the filter dropdown
        $actionTypes = Activity::select('description')
            ->distinct()
            ->pluck('description');

        // Get list of users for the filter dropdown (only users who have activities)
        $users = DB::table('users')
            ->whereIn('id', Activity::select('causer_id')->whereNotNull('causer_id')->distinct())
            ->select('id', 'name')
            ->get();

        // Paginate the results
        $activities = $query->latest()->paginate(20);

        return view('administracion.logs.activity', compact(
            'activities',
            'actionTypes',
            'users'
        ));
    }

    /**
     * Shows system logs
     *
     * This method displays system-generated logs from Laravel log files.
     * It allows viewing, filtering, and downloading system logs, which are
     * critical for debugging application errors and monitoring system health.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function system(Request $request)
    {
        // Verify permissions
        if (!Auth::user()->can('logs.view.system')) {
            return redirect()->route('administracion.logs.index')
                ->with('error', 'No tienes permisos para ver los registros del sistema');
        }

        // Get available log files
        $logFiles = $this->getLogFiles();

        // Sort by date (newest first)
        usort($logFiles, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        // Paginate the log files manually
        $page = $request->get('page', 1);
        $perPage = 15;
        $total = count($logFiles);

        $logFiles = array_slice($logFiles, ($page - 1) * $perPage, $perPage);

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $logFiles,
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('administracion.logs.system', compact('paginator'));
    }

    /**
     * Shows only error logs
     *
     * This method focuses specifically on error logs, which are critical
     * for identifying and resolving system issues. It extracts error
     * information from various log sources for easy viewing.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function errors(Request $request)
    {
        // Verify permissions
        if (!Auth::user()->can('logs.view.errors')) {
            return redirect()->route('administracion.logs.index')
                ->with('error', 'No tienes permisos para ver los registros de errores');
        }

        // Extract errors from recent log files
        $errorEntries = $this->extractErrorEntries();

        // Sort by date (newest first)
        usort($errorEntries, function($a, $b) {
            return strtotime($b['datetime']) - strtotime($a['datetime']);
        });

        // Apply filtering
        if ($request->has('severity') && $request->severity) {
            $errorEntries = array_filter($errorEntries, function($entry) use ($request) {
                return strcasecmp($entry['level'], $request->severity) === 0;
            });
        }

        if ($request->has('search') && $request->search) {
            $search = strtolower($request->search);
            $errorEntries = array_filter($errorEntries, function($entry) use ($search) {
                return strpos(strtolower($entry['message']), $search) !== false;
            });
        }

        // Group by level for statistics
        $levelStats = [];
        foreach ($errorEntries as $entry) {
            $level = $entry['level'];
            if (!isset($levelStats[$level])) {
                $levelStats[$level] = 0;
            }
            $levelStats[$level]++;
        }

        // Paginate the results manually
        $page = $request->get('page', 1);
        $perPage = 20;
        $total = count($errorEntries);

        $paginatedErrors = array_slice($errorEntries, ($page - 1) * $perPage, $perPage);

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedErrors,
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('administracion.logs.errors', compact('paginator', 'levelStats'));
    }

    /**
     * Shows login activity logs
     *
     * This method displays login attempts, both successful and failed,
     * with information on user, IP, browser, and timestamps. It's important
     * for security monitoring and detecting potential unauthorized access.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function login(Request $request)
    {
        // Verify permissions
        if (!Auth::user()->can('logs.view.login')) {
            return redirect()->route('administracion.logs.index')
                ->with('error', 'No tienes permisos para ver los registros de inicio de sesión');
        }

        $query = DB::table('login_activities')
            ->select(
                'login_activities.*',
                'users.name as user_name',
                'users.email as user_email'
            )
            ->leftJoin('users', 'login_activities.user_id', '=', 'users.id');

        // Apply filters if provided
        if ($request->has('user') && $request->user) {
            $query->where(function($q) use ($request) {
                $q->where('users.name', 'like', '%' . $request->user . '%')
                  ->orWhere('users.email', 'like', '%' . $request->user . '%')
                  ->orWhere('login_activities.login', 'like', '%' . $request->user . '%');
            });
        }

        if ($request->has('status')) {
            if ($request->status === 'success') {
                $query->where('succeeded', true);
            } elseif ($request->status === 'failed') {
                $query->where('succeeded', false);
            }
        }

        if ($request->has('ip') && $request->ip) {
            $query->where('ip_address', 'like', '%' . $request->ip . '%');
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->where('login_activities.created_at', '>=', Carbon::parse($request->date_from)->startOfDay());
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->where('login_activities.created_at', '<=', Carbon::parse($request->date_to)->endOfDay());
        }

        // Paginate the results
        $loginActivities = $query->orderBy('login_activities.created_at', 'desc')->paginate(20);

        // Get stats for the dashboard
        $totalSuccessful = DB::table('login_activities')->where('succeeded', true)->count();
        $totalFailed = DB::table('login_activities')->where('succeeded', false)->count();
        $recentFailures = DB::table('login_activities')
            ->where('succeeded', false)
            ->where('created_at', '>=', now()->subDays(1))
            ->count();

        // Get top failed IPs
        $topFailedIps = DB::table('login_activities')
            ->select('ip_address', DB::raw('count(*) as total'))
            ->where('succeeded', false)
            ->groupBy('ip_address')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        return view('administracion.logs.login', compact(
            'loginActivities',
            'totalSuccessful',
            'totalFailed',
            'recentFailures',
            'topFailedIps'
        ));
    }

    /**
     * Shows log detail for a specific date
     *
     * This method displays detailed log information for a specific date,
     * allowing deep investigation of system behavior and errors on that day.
     *
     * @param string $date Format: Y-m-d
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function show($date, Request $request)
    {
        // Verify permissions
        if (!Auth::user()->can('logs.view.system')) {
            return redirect()->route('administracion.logs.index')
                ->with('error', 'No tienes permisos para ver los registros del sistema');
        }

        // Validate date format
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return redirect()->route('administracion.logs.system')
                ->with('error', 'Formato de fecha inválido');
        }

        // Find the log file for this date
        $logFiles = $this->getLogFiles();
        $logFile = null;

        foreach ($logFiles as $file) {
            if ($file['date'] === $date) {
                $logFile = $file;
                break;
            }
        }

        if (!$logFile) {
            return redirect()->route('administracion.logs.system')
                ->with('error', 'No se encontró el archivo de registro para la fecha especificada');
        }

        // Read and parse the log file
        $logContent = file_get_contents(storage_path('logs/' . $logFile['name']));

        // Apply filtering if requested
        $filterLevel = $request->get('level');
        $search = $request->get('search');

        $logEntries = $this->parseLogContent($logContent);

        if ($filterLevel) {
            $logEntries = array_filter($logEntries, function($entry) use ($filterLevel) {
                return strcasecmp($entry['level'], $filterLevel) === 0;
            });
        }

        if ($search) {
            $search = strtolower($search);
            $logEntries = array_filter($logEntries, function($entry) use ($search) {
                return strpos(strtolower($entry['message']), $search) !== false;
            });
        }

        // Count entries by level for statistics
        $levelCounts = [];
        foreach ($logEntries as $entry) {
            $level = $entry['level'];
            if (!isset($levelCounts[$level])) {
                $levelCounts[$level] = 0;
            }
            $levelCounts[$level]++;
        }

        // Paginate the results manually
        $page = $request->get('page', 1);
        $perPage = 50;
        $total = count($logEntries);

        $logEntries = array_slice($logEntries, ($page - 1) * $perPage, $perPage);

        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $logEntries,
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('administracion.logs.show', compact(
            'paginator',
            'date',
            'levelCounts',
            'logFile'
        ));
    }

    /**
     * Downloads log file for a specific date
     *
     * This method allows administrators to download the raw log file
     * for a specific date, which can be useful for offline analysis
     * or sharing with developers for troubleshooting.
     *
     * @param string $date Format: Y-m-d
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($date)
    {
        // Verify permissions
        if (!Auth::user()->can('logs.download')) {
            return redirect()->route('administracion.logs.system')
                ->with('error', 'No tienes permisos para descargar los registros del sistema');
        }

        // Validate date format
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return redirect()->route('administracion.logs.system')
                ->with('error', 'Formato de fecha inválido');
        }

        // Find the log file for this date
        $logFiles = $this->getLogFiles();
        $logFile = null;

        foreach ($logFiles as $file) {
            if ($file['date'] === $date) {
                $logFile = $file;
                break;
            }
        }

        if (!$logFile) {
            return redirect()->route('administracion.logs.system')
                ->with('error', 'No se encontró el archivo de registro para la fecha especificada');
        }

        $filePath = storage_path('logs/' . $logFile['name']);

        // Log this download action
        Log::info('Usuario descargó archivo de logs', [
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'file' => $logFile['name'],
            'date' => $date
        ]);

        return response()->download($filePath);
    }

    /**
     * Deletes log file for a specific date
     *
     * This method allows administrators to delete log files for specific dates
     * to manage disk space. It includes confirmation and permission checks
     * to prevent accidental or unauthorized deletions.
     *
     * @param string $date Format: Y-m-d
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($date, Request $request)
    {
        // Verify permissions
        if (!Auth::user()->can('logs.delete')) {
            return redirect()->route('administracion.logs.system')
                ->with('error', 'No tienes permisos para eliminar los registros del sistema');
        }

        // Validate confirmation
        $validator = Validator::make($request->all(), [
            'confirm_delete' => 'required|boolean|accepted',
        ]);

        if ($validator->fails()) {
            return redirect()->route('administracion.logs.system')
                ->with('error', 'Debes confirmar la eliminación del archivo de registro');
        }

        // Validate date format
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return redirect()->route('administracion.logs.system')
                ->with('error', 'Formato de fecha inválido');
        }

        // Find the log file for this date
        $logFiles = $this->getLogFiles();
        $logFile = null;

        foreach ($logFiles as $file) {
            if ($file['date'] === $date) {
                $logFile = $file;
                break;
            }
        }

        if (!$logFile) {
            return redirect()->route('administracion.logs.system')
                ->with('error', 'No se encontró el archivo de registro para la fecha especificada');
        }

        $filePath = storage_path('logs/' . $logFile['name']);

        // Make sure the file still exists
        if (!File::exists($filePath)) {
            return redirect()->route('administracion.logs.system')
                ->with('error', 'El archivo de registro ya no existe');
        }

        // Try to delete the file
        try {
            File::delete($filePath);

            // Log this action
            Log::warning('Usuario eliminó archivo de logs', [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'file' => $logFile['name'],
                'date' => $date
            ]);

            return redirect()->route('administracion.logs.system')
                ->with('success', 'Archivo de registro eliminado correctamente');

        } catch (\Exception $e) {
            Log::error('Error al eliminar archivo de logs', [
                'user_id' => Auth::id(),
                'file' => $logFile['name'],
                'error' => $e->getMessage()
            ]);

            return redirect()->route('administracion.logs.system')
                ->with('error', 'Error al eliminar el archivo: ' . $e->getMessage());
        }
    }

    /**
     * Gets a list of all log files with metadata
     *
     * This helper method scans the logs directory and extracts information
     * about each log file, including date, size, and modification time.
     *
     * @return array
     */
    protected function getLogFiles()
    {
        $logDirectory = storage_path('logs');
        $files = File::files($logDirectory);
        $logFiles = [];

        foreach ($files as $file) {
            $filename = $file->getFilename();

            // Skip non-laravel log files
            if (!preg_match('/^laravel-.*\.log$/', $filename)) {
                continue;
            }

            // Extract date from filename
            preg_match('/^laravel-(\d{4}-\d{2}-\d{2})\.log$/', $filename, $matches);
            $date = $matches[1] ?? date('Y-m-d', $file->getMTime());

            $logFiles[] = [
                'name' => $filename,
                'date' => $date,
                'size' => $this->formatBytes($file->getSize()),
                'raw_size' => $file->getSize(),
                'modified' => Carbon::createFromTimestamp($file->getMTime())->format('Y-m-d H:i:s')
            ];
        }

        return $logFiles;
    }

    /**
     * Formats bytes to human-readable size
     *
     * This utility method converts raw byte sizes to human-readable formats
     * with appropriate units (KB, MB, GB).
     *
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    protected function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Gets the total size of all log files
     *
     * This helper method calculates the total storage space used by
     * all log files, which is useful for monitoring disk usage.
     *
     * @return string
     */
    protected function getLogStorageSize()
    {
        $logFiles = $this->getLogFiles();
        $totalSize = 0;

        foreach ($logFiles as $file) {
            $totalSize += $file['raw_size'];
        }

        return $this->formatBytes($totalSize);
    }

    /**
     * Counts total errors in system logs
     *
     * This helper method scans log files to count the total number
     * of error entries, providing a quick metric for system health.
     *
     * @return int
     */
    protected function countSystemErrors()
    {
        $errorCount = 0;
        $logFiles = $this->getLogFiles();

        // Limit to the last 5 log files to avoid performance issues
        $logFiles = array_slice($logFiles, 0, 5);

        foreach ($logFiles as $logFile) {
            $logContent = file_get_contents(storage_path('logs/' . $logFile['name']));

            // Count ERROR and CRITICAL entries
            $errorCount += preg_match_all('/\[\d{4}-\d{2}-\d{2}[^\]]*\]\s+(\w+)\.ERROR/i', $logContent, $matches);
            $errorCount += preg_match_all('/\[\d{4}-\d{2}-\d{2}[^\]]*\]\s+(\w+)\.CRITICAL/i', $logContent, $matches);
        }

        return $errorCount;
    }

    /**
     * Extracts error entries from log files
     *
     * This helper method parses log files to extract detailed information
     * about error entries, useful for the errors view.
     *
     * @param int $limit
     * @return array
     */
    protected function extractErrorEntries($limit = 100)
    {
        $errorEntries = [];
        $logFiles = $this->getLogFiles();

        // Sort log files by date (newest first)
        usort($logFiles, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        // Limit to recent files
        $logFiles = array_slice($logFiles, 0, 5);

        foreach ($logFiles as $logFile) {
            $date = $logFile['date'];
            $logContent = file_get_contents(storage_path('logs/' . $logFile['name']));

            // Regex pattern to extract log entries
            $pattern = '/\[(\d{4}-\d{2}-\d{2}\s+\d{2}:\d{2}:\d{2})\]\s+(\w+)\.([A-Z]+):\s+(.*?)(?=\[\d{4}-\d{2}-\d{2}|$)/s';

            if (preg_match_all($pattern, $logContent, $matches, PREG_SET_ORDER)) {
                foreach ($matches as $match) {
                    $level = $match[3];

                    // Only extract ERROR, CRITICAL, ALERT, EMERGENCY levels
                    if (!in_array($level, ['ERROR', 'CRITICAL', 'ALERT', 'EMERGENCY'])) {
                        continue;
                    }

                    $errorEntries[] = [
                        'datetime' => $match[1],
                        'date' => $date,
                        'channel' => $match[2],
                        'level' => $level,
                        'message' => trim($match[4]),
                    ];

                    // Break if we reach the limit
                    if (count($errorEntries) >= $limit) {
                        break 2;
                    }
                }
            }
        }

        return $errorEntries;
    }

    /**
     * Parses raw log content into structured entries
     *
     * This helper method converts raw log file text into structured data
     * that can be displayed, filtered, and paginated in the views.
     *
     * @param string $content
     * @return array
     */
    protected function parseLogContent($content)
    {
        $entries = [];
        $pattern = '/\[(\d{4}-\d{2}-\d{2}\s+\d{2}:\d{2}:\d{2})\]\s+(\w+)\.([A-Z]+):\s+(.*?)(?=\[\d{4}-\d{2}-\d{2}|$)/s';

        if (preg_match_all($pattern, $content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $entries[] = [
                    'datetime' => $match[1],
                    'channel' => $match[2],
                    'level' => $match[3],
                    'message' => trim($match[4]),
                    'stack_trace' => $this->extractStackTrace(trim($match[4])),
                ];
            }
        }

        return $entries;
    }

    /**
     * Extracts stack trace from error messages
     *
     * This helper method separates the main error message from
     * any stack trace information for cleaner display.
     *
     * @param string $message
     * @return string|null
     */
    protected function extractStackTrace($message)
    {
        $lines = explode("\n", $message);

        if (count($lines) > 1) {
            // First line is usually the main message
            array_shift($lines);
            return implode("\n", $lines);
        }

        return null;
    }

    /**
     * Purges old log files
     *
     * This maintenance method removes log files older than a specified
     * number of days to manage disk space. It can be triggered manually
     * or via scheduled tasks.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function purgeOldLogs(Request $request)
    {
        // Verify permissions
        if (!Auth::user()->can('logs.delete')) {
            return redirect()->route('administracion.logs.system')
                ->with('error', 'No tienes permisos para eliminar registros');
        }

        // Validate input
        $validator = Validator::make($request->all(), [
            'days_to_keep' => 'required|integer|min:7|max:365',
            'confirm_purge' => 'required|boolean|accepted',
        ]);

        if ($validator->fails()) {
            return redirect()->route('administracion.logs.system')
                ->withErrors($validator)
                ->withInput();
        }

        $daysToKeep = $request->days_to_keep;
        $cutoffDate = Carbon::now()->subDays($daysToKeep);

        $logFiles = $this->getLogFiles();
        $deletedCount = 0;
        $failedCount = 0;

        foreach ($logFiles as $file) {
            $fileDate = Carbon::parse($file['date']);

            // Skip files newer than the cutoff date
            if ($fileDate->gt($cutoffDate)) {
                continue;
            }

            $filePath = storage_path('logs/' . $file['name']);

            // Try to delete the file
            try {
                if (File::exists($filePath)) {
                    File::delete($filePath);
                    $deletedCount++;
                }
            } catch (\Exception $e) {
                $failedCount++;
                Log::error('Error al eliminar archivo de logs durante purga', [
                    'file' => $file['name'],
                    'error' => $e->getMessage()
                ]);
            }
        }
    }
}
