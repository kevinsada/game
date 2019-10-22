<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

Broadcast::channel('quiz.1', function () {
    Log::info('FUBARRRR');
    $userId = auth()->id();
    return true;
//    return $userId === $id->id;
});
