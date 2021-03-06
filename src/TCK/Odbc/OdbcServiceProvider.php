<?php

namespace TCK\Odbc;

use Illuminate\Support\ServiceProvider;

class ODBCServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array();
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {
        $factory = $this->app['db'];
        $factory->extend('odbc', function ( $config ) {
            if (!isset($config['prefix'])) {
                $config['prefix'] = '';
            }

            $connector = new Generic\ODBCConnector();
            $pdo = $connector->connect($config);

            return new Generic\ODBCConnection($pdo, $config['database'], $config['prefix']);
        });

        $factory->extend('ms-access', function ( $config ) {
            if (!isset($config['prefix'])) {
                $config['prefix'] = '';
            }

            $connector = new MsAccess\Connector();
            $pdo = $connector->connect($config);

            return new MsAccess\Connection($pdo, $config['database'], $config['prefix']);
        });
    }

}
