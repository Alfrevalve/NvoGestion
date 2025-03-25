<?php

namespace Modules\Administracion\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Importamos el controlador base
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class PermissionController extends Controller
{
    /**
     * Muestra la página principal de configuración del sistema
     *
     * Este método recupera y organiza todas las configuraciones del sistema,
     * posiblemente desde diferentes fuentes (base de datos, archivos .env, etc.)
     * y las presenta en una interfaz organizada por categorías lógicas.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Recuperar configuraciones almacenadas en la base de datos
        // Podemos usar un modelo Setting o trabajar con la tabla directamente
        $configuraciones = \DB::table('configuraciones')->get()->keyBy('clave');

        // Agrupar configuraciones por categorías para mejor organización
        $categorias = [
            'general' => [
                'nombre_sistema' => $configuraciones->get('nombre_sistema')?->valor ?? config('app.name'),
                'descripcion_sistema' => $configuraciones->get('descripcion_sistema')?->valor ?? '',
                'email_contacto' => $configuraciones->get('email_contacto')?->valor ?? config('mail.from.address'),
                'items_por_pagina' => $configuraciones->get('items_por_pagina')?->valor ?? 15,
            ],
            'apariencia' => [
                'logo_principal' => $configuraciones->get('logo_principal')?->valor ?? 'logo-default.png',
                'color_primario' => $configuraciones->get('color_primario')?->valor ?? '#3490dc',
                'color_secundario' => $configuraciones->get('color_secundario')?->valor ?? '#38c172',
                'modo_oscuro_predeterminado' => $configuraciones->get('modo_oscuro_predeterminado')?->valor ?? false,
            ],
            'notificaciones' => [
                'notificaciones_email' => $configuraciones->get('notificaciones_email')?->valor ?? true,
                'notificaciones_sistema' => $configuraciones->get('notificaciones_sistema')?->valor ?? true,
                'recordatorios_automaticos' => $configuraciones->get('recordatorios_automaticos')?->valor ?? true,
            ],
            'seguridad' => [
                'dias_caducidad_password' => $configuraciones->get('dias_caducidad_password')?->valor ?? 90,
                'max_intentos_login' => $configuraciones->get('max_intentos_login')?->valor ?? 5,
                'tiempo_bloqueo_minutos' => $configuraciones->get('tiempo_bloqueo_minutos')?->valor ?? 15,
                'politica_password' => $configuraciones->get('politica_password')?->valor ?? 'standard',
            ],
            'sistema' => [
                'cache_habilitada' => $configuraciones->get('cache_habilitada')?->valor ?? true,
                'debug_mode' => config('app.debug'),
                'version_sistema' => config('app.version', '1.0.0'),
                'mantenimiento_programado' => $configuraciones->get('mantenimiento_programado')?->valor ?? false,
            ]
        ];

        // Información del sistema para administradores avanzados
        $infoSistema = [
            'php_version' => phpversion(),
            'laravel_version' => app()->version(),
            'database_type' => config('database.default'),
            'server_os' => php_uname(),
            'disk_free_space' => $this->formatBytes(disk_free_space('/')),
            'disk_total_space' => $this->formatBytes(disk_total_space('/')),
            'memory_limit' => ini_get('memory_limit'),
            'max_upload_size' => ini_get('upload_max_filesize'),
            'max_execution_time' => ini_get('max_execution_time') . ' segundos',
        ];

        return view('administracion.configuracion.index', [
            'categorias' => $categorias,
            'infoSistema' => $infoSistema,
        ]);
    }

    /**
     * Actualiza las configuraciones del sistema basado en los datos recibidos
     *
     * Este método procesa el formulario de actualización de configuraciones,
     * realizando las validaciones necesarias y aplicando los cambios.
     * Dependiendo de la configuración actualizada, puede realizar acciones
     * adicionales como limpiar caché, regenerar archivos, etc.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Validación de datos según la categoría que se está actualizando
        $categoria = $request->input('categoria');

        $rules = [];
        $messages = [];

        // Reglas de validación según la categoría
        switch ($categoria) {
            case 'general':
                $rules = [
                    'nombre_sistema' => 'required|string|max:100',
                    'descripcion_sistema' => 'nullable|string|max:255',
                    'email_contacto' => 'required|email|max:100',
                    'items_por_pagina' => 'required|integer|min:5|max:100',
                ];
                break;

            case 'apariencia':
                $rules = [
                    'logo_principal' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
                    'color_primario' => 'required|string|regex:/^#[a-f0-9]{6}$/i',
                    'color_secundario' => 'required|string|regex:/^#[a-f0-9]{6}$/i',
                    'modo_oscuro_predeterminado' => 'boolean',
                ];
                break;

            case 'notificaciones':
                $rules = [
                    'notificaciones_email' => 'boolean',
                    'notificaciones_sistema' => 'boolean',
                    'recordatorios_automaticos' => 'boolean',
                ];
                break;

            case 'seguridad':
                $rules = [
                    'dias_caducidad_password' => 'required|integer|min:0|max:365',
                    'max_intentos_login' => 'required|integer|min:1|max:20',
                    'tiempo_bloqueo_minutos' => 'required|integer|min:1|max:1440',
                    'politica_password' => 'required|in:basic,standard,strong,custom',
                ];
                break;

            case 'sistema':
                $rules = [
                    'cache_habilitada' => 'boolean',
                    'mantenimiento_programado' => 'boolean',
                ];
                break;

            default:
                return redirect()->back()
                    ->with('error', 'Categoría de configuración no válida');
        }

        // Validar los datos
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Procesar y guardar las configuraciones validadas
        foreach ($rules as $campo => $regla) {
            // Saltar si el campo no está presente en la solicitud
            if (!$request->has($campo)) {
                continue;
            }

            // Manejar el caso especial de la carga de archivos
            if ($campo === 'logo_principal' && $request->hasFile('logo_principal')) {
                $logoPath = $this->guardarLogo($request->file('logo_principal'));
                $this->guardarConfiguracion($campo, $logoPath);
                continue;
            }

            // Para campos booleanos
            if (strpos($regla, 'boolean') !== false) {
                $valor = $request->boolean($campo);
            } else {
                $valor = $request->input($campo);
            }

            // Guardar en la base de datos
            $this->guardarConfiguracion($campo, $valor);
        }

        // Acciones adicionales según la categoría actualizada
        switch ($categoria) {
            case 'sistema':
                // Si se cambia la configuración de caché, actualizar en consecuencia
                if ($request->has('cache_habilitada')) {
                    if ($request->boolean('cache_habilitada')) {
                        $this->optimizarSistema();
                    } else {
                        $this->limpiarCache();
                    }
                }

                // Si se activa el modo mantenimiento
                if ($request->has('mantenimiento_programado') && $request->boolean('mantenimiento_programado')) {
                    $this->activarModoMantenimiento();
                } elseif ($request->has('mantenimiento_programado') && !$request->boolean('mantenimiento_programado')) {
                    $this->desactivarModoMantenimiento();
                }
                break;

            // Otras acciones específicas para otras categorías
        }

        return redirect()->route('administracion.configuracion.index')
            ->with('success', 'Configuración actualizada correctamente');
    }

    /**
     * Método auxiliar para guardar o actualizar una configuración
     *
     * Guarda una configuración en la tabla de la base de datos,
     * actualizándola si ya existe o creándola si es nueva.
     * También actualiza la caché para evitar consultas innecesarias.
     *
     * @param  string  $clave
     * @param  mixed  $valor
     * @return void
     */
    protected function guardarConfiguracion($clave, $valor)
    {
        // Actualizar o insertar en la base de datos
        \DB::table('configuraciones')->updateOrInsert(
            ['clave' => $clave],
            [
                'valor' => is_bool($valor) ? (int)$valor : $valor,
                'updated_at' => now()
            ]
        );

        // Actualizar la caché si está habilitada
        $cacheEnabled = \DB::table('configuraciones')
            ->where('clave', 'cache_habilitada')
            ->value('valor') ?? true;

        if ($cacheEnabled) {
            Cache::put('configuracion.' . $clave, $valor, now()->addDay());
        }
    }

    /**
     * Guarda un archivo de logo y devuelve la ruta
     *
     * Recibe un archivo de imagen, lo procesa si es necesario,
     * lo guarda en el sistema de archivos y devuelve la ruta relativa.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return string
     */
    protected function guardarLogo($file)
    {
        // Generar un nombre único para el archivo
        $nombreArchivo = 'logo_' . time() . '.' . $file->getClientOriginalExtension();

        // Guardar en el almacenamiento público
        $path = $file->storeAs('public/logos', $nombreArchivo);

        // Devolver la ruta relativa (sin 'public/')
        return Storage::url($path);
    }

    /**
     * Formatea un tamaño en bytes a una unidad más legible (KB, MB, GB)
     *
     * @param  int  $bytes
     * @param  int  $precision
     * @return string
     */
    protected function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Limpia la caché del sistema
     *
     * Ejecuta varios comandos Artisan para limpiar diferentes tipos de caché.
     *
     * @return void
     */
    protected function limpiarCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');

            Log::info('Cache del sistema limpiada manualmente por un administrador');
        } catch (\Exception $e) {
            Log::error('Error al limpiar la caché: ' . $e->getMessage());
        }
    }

    /**
     * Optimiza el sistema
     *
     * Ejecuta comandos para optimizar el rendimiento de la aplicación
     * como cachear configuraciones, rutas, vistas, etc.
     *
     * @return void
     */
    protected function optimizarSistema()
    {
        try {
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');

            Log::info('Sistema optimizado manualmente por un administrador');
        } catch (\Exception $e) {
            Log::error('Error al optimizar el sistema: ' . $e->getMessage());
        }
    }

    /**
     * Activa el modo de mantenimiento
     *
     * Pone la aplicación en modo mantenimiento, permitiendo especificar
     * una redirección, mensaje personalizado y excepciones IP.
     *
     * @return void
     */
    protected function activarModoMantenimiento()
    {
        try {
            // Obtener configuraciones adicionales de mantenimiento
            $mensaje = \DB::table('configuraciones')
                ->where('clave', 'mensaje_mantenimiento')
                ->value('valor') ?? 'El sistema está en mantenimiento. Volveremos pronto.';

            $ipsPermitidas = \DB::table('configuraciones')
                ->where('clave', 'ips_permitidas_mantenimiento')
                ->value('valor') ?? '';

            $ipsArray = array_filter(explode(',', $ipsPermitidas));

            // Construir comando con opciones
            $comando = 'down --message="' . addslashes($mensaje) . '"';

            if (!empty($ipsArray)) {
                foreach ($ipsArray as $ip) {
                    $comando .= ' --allow=' . trim($ip);
                }
            }

            Artisan::call($comando);

            Log::info('Modo mantenimiento activado por un administrador');
        } catch (\Exception $e) {
            Log::error('Error al activar modo mantenimiento: ' . $e->getMessage());
        }
    }

    /**
     * Desactiva el modo de mantenimiento
     *
     * Vuelve a poner la aplicación en línea después de un mantenimiento.
     *
     * @return void
     */
    protected function desactivarModoMantenimiento()
    {
        try {
            Artisan::call('up');

            Log::info('Modo mantenimiento desactivado por un administrador');
        } catch (\Exception $e) {
            Log::error('Error al desactivar modo mantenimiento: ' . $e->getMessage());
        }
    }

    /**
     * Muestra y permite editar configuraciones avanzadas del sistema
     *
     * Este método está destinado a administradores técnicos y muestra
     * configuraciones más complejas o peligrosas que requieren conocimiento técnico.
     *
     * @return \Illuminate\View\View
     */
    public function avanzadas()
    {
        // Verificar si el usuario tiene permisos para esta sección
        // Nota: Esto asume que estás usando spatie/laravel-permission
        if (!auth()->user()->can('configuracion.avanzadas')) {
            return redirect()->route('administracion.configuracion.index')
                ->with('error', 'No tienes permisos para acceder a configuraciones avanzadas');
        }

        // Obtener variables de entorno que se pueden modificar con seguridad
        $configuracionesEnv = [
            'APP_URL' => env('APP_URL'),
            'APP_DEBUG' => env('APP_DEBUG'),
            'QUEUE_CONNECTION' => env('QUEUE_CONNECTION'),
            'MAIL_MAILER' => env('MAIL_MAILER'),
            'MAIL_HOST' => env('MAIL_HOST'),
            'MAIL_PORT' => env('MAIL_PORT'),
            'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS'),
            'MAIL_FROM_NAME' => env('MAIL_FROM_NAME'),
            'FILESYSTEM_DISK' => env('FILESYSTEM_DISK'),
            'SESSION_LIFETIME' => env('SESSION_LIFETIME'),
            'SESSION_DRIVER' => env('SESSION_DRIVER'),
        ];

        // Comandos de mantenimiento disponibles
        $comandosMantenimiento = [
            'queue:work' => 'Procesar colas de trabajos',
            'queue:retry all' => 'Reintentar todos los trabajos fallidos',
            'storage:link' => 'Crear enlace simbólico del almacenamiento',
            'migrate' => 'Ejecutar migraciones pendientes',
            'db:seed' => 'Ejecutar semillas de la base de datos',
            'schedule:run' => 'Ejecutar tareas programadas manualmente',
            'optimize' => 'Optimizar la aplicación',
            'optimize:clear' => 'Limpiar cachés de optimización',
        ];

        return view('administracion.configuracion.avanzadas', [
            'configuracionesEnv' => $configuracionesEnv,
            'comandosMantenimiento' => $comandosMantenimiento,
        ]);
    }

    /**
     * Actualiza configuraciones avanzadas basadas en variables de entorno
     *
     * Este método actualiza el archivo .env con nuevos valores para las
     * configuraciones avanzadas del sistema. Requiere privilegios elevados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAvanzadas(Request $request)
    {
        // Verificar permisos
        if (!auth()->user()->can('configuracion.avanzadas')) {
            return redirect()->route('administracion.configuracion.index')
                ->with('error', 'No tienes permisos para modificar configuraciones avanzadas');
        }

        // Validar datos recibidos
        $validator = Validator::make($request->all(), [
            'APP_URL' => 'nullable|url',
            'APP_DEBUG' => 'nullable|boolean',
            'QUEUE_CONNECTION' => 'nullable|in:sync,database,redis,beanstalkd,sqs',
            'MAIL_MAILER' => 'nullable|in:smtp,sendmail,mailgun,ses,log,array',
            'MAIL_HOST' => 'nullable|string',
            'MAIL_PORT' => 'nullable|integer|min:1|max:65535',
            'MAIL_FROM_ADDRESS' => 'nullable|email',
            'MAIL_FROM_NAME' => 'nullable|string',
            'FILESYSTEM_DISK' => 'nullable|in:local,public,s3',
            'SESSION_LIFETIME' => 'nullable|integer|min:1',
            'SESSION_DRIVER' => 'nullable|in:file,cookie,database,apc,redis,memcached,array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Actualizar el archivo .env
        $envFile = app()->environmentFilePath();
        $contenido = file_get_contents($envFile);

        foreach ($validator->validated() as $clave => $valor) {
            if ($request->has($clave)) {
                // Convertir booleanos a string "true"/"false" para APP_DEBUG
                if ($clave == 'APP_DEBUG') {
                    $valor = $valor ? 'true' : 'false';
                }

                // Envolver valores con espacios en comillas
                if (is_string($valor) && strpos($valor, ' ') !== false) {
                    $valor = '"' . $valor . '"';
                }

                // Reemplazar la variable si existe
                if (preg_match("/^{$clave}=.*$/m", $contenido)) {
                    $contenido = preg_replace("/^{$clave}=.*$/m", "{$clave}={$valor}", $contenido);
                } else {
                    // Añadir al final si no existe
                    $contenido .= "\n{$clave}={$valor}";
                }
            }
        }

        // Guardar los cambios
        file_put_contents($envFile, $contenido);

        // Limpiar caché para aplicar cambios
        Artisan::call('config:clear');

        return redirect()->route('administracion.configuracion.avanzadas')
            ->with('success', 'Configuraciones avanzadas actualizadas correctamente. Algunos cambios pueden requerir reiniciar el servidor para surtir efecto.');
    }

    /**
     * Ejecuta un comando de mantenimiento seleccionado
     *
     * Este método permite a administradores ejecutar comandos Artisan
     * predefinidos para tareas de mantenimiento desde la interfaz.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ejecutarComando(Request $request)
    {
        // Verificar permisos
        if (!auth()->user()->can('configuracion.comandos')) {
            return redirect()->route('administracion.configuracion.avanzadas')
                ->with('error', 'No tienes permisos para ejecutar comandos de mantenimiento');
        }

        // Validar el comando recibido
        $validator = Validator::make($request->all(), [
            'comando' => 'required|string|in:queue:work,queue:retry all,storage:link,migrate,db:seed,schedule:run,optimize,optimize:clear',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', 'Comando no válido o no permitido');
        }

        // Ejecutar el comando
        try {
            $output = Artisan::call($request->comando);

            Log::info("Comando Artisan '{$request->comando}' ejecutado manualmente por administrador", [
                'usuario_id' => auth()->id(),
                'resultado' => $output
            ]);

            return redirect()->back()
                ->with('success', "Comando '{$request->comando}' ejecutado correctamente");
        } catch (\Exception $e) {
            Log::error("Error al ejecutar comando Artisan '{$request->comando}'", [
                'usuario_id' => auth()->id(),
                'error' => $e->getMessage()
            ]);

            return redirect()->back()
                ->with('error', "Error al ejecutar comando: " . $e->getMessage());
        }
    }
}
