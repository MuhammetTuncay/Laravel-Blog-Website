<?php

namespace App\Providers;

//use App\Models\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //view()->share('config', Config::find(1));  //back/layouts/header.blade.php dosyası ile bağlantılı burayıda yorum satırına aldım.
        /*
            Route::resourceVerbs([
            'create'=>'oluştur',
            'edit'=>'güncelle',
        ]);
        */
    }
}
