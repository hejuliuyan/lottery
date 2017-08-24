<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DBQuerylogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $app = $this->app;
        $db = $app['db'];
        $db->listen(
            function ($query, $bindings, $time, $connectionName) use ($db) {
                $connection = $db->connection($connectionName);
                $pdo = $connection->getPdo();
                $bindings = $connection->prepareBindings($bindings);
                $querys = [];
                foreach ($bindings as $binding) {
                    $querys = preg_replace('/\?/', $pdo->quote($binding), $query, 1);
                }
                dd($query,$querys);
            }
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
