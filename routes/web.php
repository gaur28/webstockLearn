<?php

use BeyondCode\LaravelWebSockets\Dashboard\DashboardLogger;
use BeyondCode\LaravelWebSockets\Apps\AppProvider;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function (AppProvider $appProvider) {
    return view('webstockExample', [
        'port' => env('LARAVEL_WEBSOCKET_PORT'),
        'host' => env('LARAVEL_WEBSOCKET_HOST'),
        "authEndpoint" => '/api/sockets/connect',
        "logChannel"=> DashboardLogger::LOG_CHANNEL_PREFIX,
          'apps'=> $appProvider->all()
    ]);
});
