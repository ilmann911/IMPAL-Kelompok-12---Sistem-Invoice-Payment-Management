<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // Wajib ditambahkan

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
    public function boot(): void
    {
        // Solusi Paling Aman: Memaksa HTTPS HANYA jika diakses lewat domain Azure
        // Dengan begini, localhost laptopmu tetap aman pakai HTTP biasa, 
        // dan Azure otomatis pakai HTTPS tanpa peduli isi file .env
        if (str_contains(request()->getHost(), 'azurewebsites.net')) {
            URL::forceScheme('https');
        }
    }
}