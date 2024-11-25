<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Broadcast::routes();

        Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
            return true; // Проверьте, является ли пользователь участником чата
        });

        require base_path('routes/channels.php');
    }

}
