<?php

use App\Http\Controllers\UserController;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
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







Route::name('user.')->controller(UserController::class)->group(function(){
    Route::middleware('PreventBackHistory')->group(function(){
        Route::middleware(['guest:web'])->group(function(){
            Route::get('login','LoginPage')->name('login');
            Route::get('register','RegisterPage')->name('register');
            Route::post('create','create')->name('create');
            Route::post('check','check')->name('check');
        });
        Route::middleware(['auth:web'])->group(function(){
            Route::get('logout','logout')->name('logout');
            Route::get('/','homepage')->name('homepage');
            Route::get('/convo/{convo}','convopage')->name('convopage');
            Route::post('/send-message','sendmessage')->name('send-message');
            Route::get('/search-user','searchUser')->name('search-user');
            Route::get('/new-convo/{id}','newConvo')->name('new-convo');
        });
    });
});
