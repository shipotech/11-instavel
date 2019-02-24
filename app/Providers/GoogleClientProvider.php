<?php

namespace App\Providers;

use Google_Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class GoogleClientProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(Google_Client::class, function ($app) {
            $client = new Google_Client();

            // You need to put ur client_secret.json on somewhere secure, for example "storage/app/"
            Storage::disk('local')->put('client_secret.json', json_encode([
                'web' => config('services.google')
            ]));
            $client->setAuthConfig(Storage::path('client_secret.json'));
            return $client;
        });
    }
}
