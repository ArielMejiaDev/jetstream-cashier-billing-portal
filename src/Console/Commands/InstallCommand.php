<?php

namespace RenokiCo\BillingPortal\Console\Commands;

use Illuminate\Filesystem\Filesystem;
use Laravel\Jetstream\Console\InstallCommand as JetstreamInstallCommand;

class InstallCommand extends JetstreamInstallCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing-portal:install {stack=inertia} {--stripe=true}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Jetstream Cashier Billing Portal components and resources.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->installCashierRegisterStack();

        $this->installInertiaStack();
    }

    /**
     * Install the Cashier Register stack into the application.
     *
     * @return void
     */
    protected function installCashierRegisterStack()
    {
        $this->requireComposerPackages('laravel/cashier:^12.6');

        $this->callSilent('vendor:publish', ['--provider' => 'RenokiCo\CashierRegister\CashierRegisterServiceProvider', '--tag' => 'config', '--force' => true]);
        $this->callSilent('vendor:publish', ['--provider' => 'RenokiCo\CashierRegister\CashierRegisterServiceProvider', '--tag' => 'migrations', '--force' => true]);
        $this->callSilent('vendor:publish', ['--provider' => 'RenokiCo\CashierRegister\CashierRegisterServiceProvider', '--tag' => 'provider', '--force' => true]);
    }

    /**
     * Install the Inertia stack into the application.
     *
     * @return void
     */
    protected function installInertiaStack()
    {
        $this->callSilent('vendor:publish', ['--provider' => 'RenokiCo\BillingPortal\BillingPortalServiceProvider', '--tag' => 'config', '--force' => true]);

        (new Filesystem)->ensureDirectoryExists(resource_path('js/Pages/BillingPortal'));
        (new Filesystem)->ensureDirectoryExists(resource_path('js/BillingPortal'));

        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/inertia/resources/js/Pages/BillingPortal', resource_path('js/Pages/BillingPortal'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../../stubs/inertia/resources/js/BillingPortal', resource_path('js/BillingPortal'));
    }
}
