<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
		$timezone = \DB::table('appsettings')->where('id', 3)->get();
		//echo "-".$timezone[0]->Value;exit;
		\Config::set('app.timezone', $timezone[0]->Value);
		
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
