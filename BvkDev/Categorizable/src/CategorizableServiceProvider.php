<?php

namespace BvkDev\Categorizable;

use Illuminate\Support\ServiceProvider;

class CategorizableServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/categorizable.php', 'categorizable');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/database/migrations/2021_12_21_084652_create_categories_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_categories_tables.php'),
        ], 'migrations');
        $this->publishes([
            __DIR__.'/config/categorizable.php' => config_path('categorizable.php'),
        ], 'config');

    }
}
