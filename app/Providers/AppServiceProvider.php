<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    // W pliku App\Providers\AppServiceProvider.php



    public function boot()
    {
        View::composer('*', function ($view) {
            // Tutaj pobieramy dane z bazy danych
            $ticketTypes = DB::table('ticket_types')->get();
            // Przekazujemy te dane do wszystkich widoków
            $view->with('ticketTypes', $ticketTypes);
        });
    }
}
