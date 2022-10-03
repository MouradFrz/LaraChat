<?php

use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/chat-page',function(){
    dd(User::find(1)->messages);
    return view('chatpage');
})->name('chat-page');

Route::post('/send-message',function(Request $request){
    event(New App\Events\ChatMessage($request->message));
})->name('send-message');


Route::prefix('user')->name('user.')->controller(UserController::class)->group(function(){
    Route::middleware('PreventBackHistory')->group(function(){
        Route::middleware(['guest:web'])->group(function(){
            Route::get('login','LoginPage')->name('login');
            Route::get('register','RegisterPage')->name('register');
            Route::post('create','create')->name('create');
            Route::post('check','check')->name('check');
        });
        Route::middleware(['auth:web'])->group(function(){
            Route::get('logout','logout')->name('logout');
        });
    });
});
