<?php

namespace Modules\Cirugias\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

// Events
use Modules\Cirugias\Events\CirugiaScheduled;
use Modules\Cirugias\Events\CirugiaRescheduled;
use Modules\Cirugias\Events\CirugiaCancelled;
use Modules\Cirugias\Events\CirugiaCompleted;
use Modules\Cirugias\Events\CirugiaStatusChanged;
use Modules\Cirugias\Events\EquipoAsignado;
use Modules\Cirugias\Events\MaterialInventoryLow;
use Modules\Cirugias\Events\QuirofanoAsignado;
use Modules\Cirugias\Events\PostOperatorioRegistrado;

// Listeners
use Modules\Cirugias\Listeners\SendCirugiaNotification;
use Modules\Cirugias\Listeners\UpdateCalendario;
use Modules\Cirugias\Listeners\NotifyMedicalTeam;
use Modules\Cirugias\Listeners\NotifyPatient;
use Modules\Cirugias\Listeners\UpdateMaterialInventory;
use Modules\Cirugias\Listeners\LogCirugiaActivity;
use Modules\Cirugias\Listeners\CreatePostOperatorioReminder;
use Modules\Cirugias\Listeners\NotifyInventoryManager;
use Modules\Cirugias\Listeners\GenerateCirugiaReport;
use Modules\Cirugias\Listeners\SynchronizeWithExternalSystem;

// Observers
use Modules\Cirugias\Models\Cirugia;
use Modules\Cirugias\Models\Medico;
use Modules\Cirugias\Models\Material;
use Modules\Cirugias\Models\Equipo;
use Modules\Cirugias\Models\Quirofano;
use Modules\Cirugias\Observers\CirugiaObserver;
use Modules\Cirugias\Observers\MedicoObserver;
use Modules\Cirugias\Observers\MaterialObserver;
use Modules\Cirugias\Observers\EquipoObserver;
use Modules\Cirugias\Observers\QuirofanoObserver;

// Subscribers
use Modules\Cirugias\Subscribers\CirugiaSubscriber;
use Modules\Cirugias\Subscribers\InventarioSubscriber;

/**
 * Event Service Provider for the Cirugías Module
 *
 * This provider registers all event listeners, subscribers and model observers
 * related to surgical operations management.
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [
        // Surgery lifecycle events
        CirugiaScheduled::class => [
            SendCirugiaNotification::class,
            UpdateCalendario::class,
            NotifyMedicalTeam::class,
            NotifyPatient::class,
            LogCirugiaActivity::class,
        ],

        CirugiaRescheduled::class => [
            SendCirugiaNotification::class,
            UpdateCalendario::class,
            NotifyMedicalTeam::class,
            NotifyPatient::class,
            LogCirugiaActivity::class,
        ],

        CirugiaCancelled::class => [
            SendCirugiaNotification::class,
            UpdateCalendario::class,
            NotifyMedicalTeam::class,
            NotifyPatient::class,
            LogCirugiaActivity::class,
        ],

        CirugiaCompleted::class => [
            SendCirugiaNotification::class,
            UpdateMaterialInventory::class,
            LogCirugiaActivity::class,
            CreatePostOperatorioReminder::class,
            GenerateCirugiaReport::class,
            SynchronizeWithExternalSystem::class,
        ],

        CirugiaStatusChanged::class => [
            SendCirugiaNotification::class,
            LogCirugiaActivity::class,
            UpdateCalendario::class,
        ],

        // Resource assignment events
        EquipoAsignado::class => [
            LogCirugiaActivity::class,
            NotifyMedicalTeam::class,
        ],

        QuirofanoAsignado::class => [
            UpdateCalendario::class,
            LogCirugiaActivity::class,
            NotifyMedicalTeam::class,
        ],

        // Inventory events
        MaterialInventoryLow::class => [
            NotifyInventoryManager::class,
        ],

        // Post-operative events
        PostOperatorioRegistrado::class => [
            NotifyMedicalTeam::class,
            NotifyPatient::class,
            GenerateCirugiaReport::class,
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array<int, string>
     */
    protected $subscribe = [
        CirugiaSubscriber::class,
        InventarioSubscriber::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();

        // Register model observers
        $this->registerModelObservers();

        // Register any manual event listeners
        $this->registerManualEventListeners();
    }

    /**
     * Register model observers for tracking model changes.
     *
     * @return void
     */
    protected function registerModelObservers(): void
    {
        Cirugia::observe(CirugiaObserver::class);
        Medico::observe(MedicoObserver::class);
        Material::observe(MaterialObserver::class);
        Equipo::observe(EquipoObserver::class);
        Quirofano::observe(QuirofanoObserver::class);
    }

    /**
     * Register any manual event listeners that cannot be easily declared in the $listen array.
     *
     * @return void
     */
    protected function registerManualEventListeners(): void
    {
        // Example of a complex event listener with dependency injection
        Event::listen(function (CirugiaCompleted $event) {
            // You could add complex logic here, or inject dependencies
            // that can't be handled with standard listeners
            $integrationService = app()->make('cirugias.integration');
            $integrationService->synchronizeCompletedSurgery($event->cirugia);
        });

        // Example of a wildcard event listener for all cirugia events
        Event::listen('Modules\Cirugias\Events\*', function ($eventName, array $data) {
            // Log all cirugia-related events
            logger()->info('Cirugia event fired: ' . $eventName, [
                'data' => $data,
                'user_id' => auth()->id() ?? 'system',
                'timestamp' => now()->toDateTimeString()
            ]);
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents(): bool
    {
        // Set to true to enable automatic event discovery
        // This will scan the Listeners directory for event listeners
        return false;
    }

    /**
     * Get the listener directories that should be used to discover events.
     *
     * @return array<int, string>
     */
    protected function discoverEventsWithin(): array
    {
        return [
            module_path('Cirugias', 'Listeners'),
        ];
    }
}
