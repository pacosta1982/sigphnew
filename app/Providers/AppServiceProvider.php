<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        view()->composer('*', function ($view) {

            //$user = User::find(Auth::id())->get();
            //var_dump($user.'abc');
            $view->with('user', Auth::user());

        });

        view()->composer('messenger.messagesdropdown',function($view){
            $threads = Thread::forUser(Auth::id())->latest('updated_at')->get();
            $view->with('threads',$threads);

        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
