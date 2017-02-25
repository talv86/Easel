<?php
/**
 * Created by PhpStorm.
 * User: talv
 * Date: 10/07/16
 * Time: 16:04.
 */
namespace Easel\Providers;

use Collective\Html\FormFacade;
use Collective\Html\HtmlFacade;
use Collective\Html\HtmlServiceProvider;
use Easel\Console\Commands\InstallCommand;
use Easel\Console\Commands\UpdateCommand;
use Easel\Models\BlogUserInterface;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Laravel\Scout\ScoutServiceProvider;
use Proengsoft\JsValidation\Facades\JsValidatorFacade;
use Proengsoft\JsValidation\JsValidationServiceProvider;
use Spatie\Backup\BackupServiceProvider;
use TalvBansal\MediaManager\Providers\MediaManagerServiceProvider;
use TeamTNT\Scout\TNTSearchScoutServiceProvider;

/**
 * Class EaselServiceProvider.
 */
class EaselServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load the view files
        $this->loadViewsFrom(EASEL_BASE_PATH.'/resources/views', 'easel');
        // Load language files
        $this->loadTranslationsFrom(EASEL_BASE_PATH.'/resources/lang', 'easel');

        $this->defineRoutes();

        if ($this->app->runningInConsole()) {
            $this->defineResources();
            $this->defineMigrations();
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Define package base path
        if (!defined('EASEL_BASE_PATH')) {
            define('EASEL_BASE_PATH', realpath(__DIR__.'/../../'));
        }

        // When running artisan add these commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                UpdateCommand::class,
            ]);
        }

        $this->registerServices();

        // Merge any new config items into the existing config file
        $this->mergeConfigFrom(
            EASEL_BASE_PATH.'/config/easel.php', 'easel'
        );

        // Merge any new config items into the existing config file
        $this->mergeConfigFrom(
            EASEL_BASE_PATH.'/config/scout.php', 'scout'
        );

        $this->app->bind(BlogUserInterface::class, config('easel.user_model'));
    }

    /**
     * Load Easel specific routes.
     */
    private function defineRoutes()
    {
        if (!$this->app->routesAreCached()) {
            \Route::group(['namespace' => 'Easel\Http\Controllers'],
                function ($router) {
                    require EASEL_BASE_PATH.'/src/Http/routes.php';
                }
            );
        }
    }

    /**
     * Publish assets / images / css / js / views to host application
     * This is only when the application is run in the console.
     */
    private function defineResources()
    {
        $this->publishes([
            EASEL_BASE_PATH.'/resources/publish' => base_path('resources/views/vendor/easel/'),
        ]);

        $this->publishes([
            EASEL_BASE_PATH.'/public' => base_path('public'),
        ]);

        $this->publishes([
            EASEL_BASE_PATH.'/resources/assets/storage' => storage_path('app/public'),
        ]);
    }

    /**
     * Publish database migrations / seeds / factories to host application
     * This is only when the application is run in the console.
     */
    private function defineMigrations()
    {
        $this->publishes([
            EASEL_BASE_PATH.'/database/migrations/' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            EASEL_BASE_PATH.'/database/seeds/' => database_path('seeds'),
        ], 'seeds');

        $this->publishes([
            EASEL_BASE_PATH.'/database/factories/' => database_path('factories'),
        ], 'factories');
    }

    /**
     * Load this packages dependant service providers and facades.
     */
    private function registerServices()
    {
        //register service providers
        $this->app->register(BackupServiceProvider::class);
        $this->app->register(HtmlServiceProvider::class);
        $this->app->register(JsValidationServiceProvider::class);
        $this->app->register(MediaManagerServiceProvider::class);
        $this->app->register(ScoutServiceProvider::class);
        $this->app->register(TNTSearchScoutServiceProvider::class);

        //load facades
        $loader = AliasLoader::getInstance();
        $loader->alias('JsValidator', JsValidatorFacade::class);
        $loader->alias('Form', FormFacade::class);
        $loader->alias('Html', HtmlFacade::class);
    }
}
