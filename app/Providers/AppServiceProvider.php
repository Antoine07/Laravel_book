<?php

namespace App\Providers;

use App\Score;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend('uniqueVoteIp', function ($attribute, $value, $parameters, $validator) {
            
            $count = Score::where('book_id', $value)->where('ip', $parameters[0])->count();
                                        
            return $count === 0;
        });
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
