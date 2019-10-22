<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::channel('quiz.1', function ($user, $userId) {
            return true;
        });


        Broadcast::routes();
        require base_path('routes/channels.php');
    }
}
