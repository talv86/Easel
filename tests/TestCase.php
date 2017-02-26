<?php

use Easel\Providers\EaselServiceProvider;

/**
 * Class TestCase.
 */
class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    public function setUp()
    {
        parent::setUp();

        $this->artisan('migrate', [
            '--database' => 'test',
            '--realpath' => realpath(__DIR__.'/../database/migrations'),
        ]);

        $this->withFactories(realpath(__DIR__.'/../database/factories'));

        $this->artisan('easel:install');
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [EaselServiceProvider::class];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $this->resetIndexes();

        $app['path.base'] = realpath(__DIR__.'../src');

        $app['config']->set('database.default', 'test');
        $app['config']->set('database.connections.test', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
            'strict'   => false,
        ]);

        //create temp folder
        $app['config']->set('filesystems.disks.public', [
            'driver' => 'local',
            'root'   => $this->getPublicDir(),
        ]);

        //set test user model
        $app['config']->set('auth.providers.users', [
            'driver' => 'eloquent',
            'model'  => \Easel\Models\User::class,
        ]);
    }

    public function getTempDirectory($suffix = '')
    {
        return __DIR__.'/temp'.($suffix == '' ? '' : '/'.$suffix);
    }

    public function getPublicDir($suffix = '')
    {
        return $this->getTempDirectory().'/app/public'.($suffix == '' ? '' : '/'.$suffix);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    private function resetIndexes()
    {
        $storagePath = str_finish(realpath(storage_path()), DIRECTORY_SEPARATOR).'*.index';

        return collect(\File::glob($storagePath))->each(function ($index) {
            unlink($index);
        });
    }
}
