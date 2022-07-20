<?php

use Illuminate\Support\Facades\Http;
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

// Admin functionality

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/', [\App\Http\Controllers\Admin\MainController::class, 'index'])->name('main.index');
    Route::resource('settings', \App\Http\Controllers\Admin\SettingController::class);
    Route::resource('posts', \App\Http\Controllers\Admin\PostController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('genders', \App\Http\Controllers\Admin\GenderController::class);
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
    Route::resource('occupations', \App\Http\Controllers\Admin\OccupationController::class);
    Route::match(['put', 'patch'], 'users/{user}/change_password', [\App\Http\Controllers\Admin\UserController::class, 'change_password'])->name('users.change_password');
    Route::group(['as' => 'profile.', 'prefix' => 'profile'], function () {
        Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'profile'])->name('index');
    });

    // manage tracks
    Route::resource('tracks', \App\Http\Controllers\Admin\TrackController::class);
    // manage block of the track
    Route::resource('tracks.blocks', \App\Http\Controllers\Admin\BlockController::class);
    // manage exercises of the block
    Route::resource('blocks.exercises', \App\Http\Controllers\Admin\ExerciseController::class);
    // index, show and delete the answers of the exercise
    Route::resource('exercises.answers', \App\Http\Controllers\Admin\AnswerController::class)->except(['create', 'edit', 'store', 'update']);
});

// Authorization user

Route::group(['as' => 'auth.'], function () {
    Route::group(['middleware' => 'guest'], function () {
        // Login user
        Route::group(['as'=> 'login', 'prefix' => 'login'], function () {
            Route::get('/', [\App\Http\Controllers\Auth\LoginController::class, 'index']);
            Route::post('/', [\App\Http\Controllers\Auth\LoginController::class, 'submit'])->name('.submit');
        });

        // Register user
        Route::group(['as'=> 'register', 'prefix' => 'register'], function () {
            Route::get('/', [\App\Http\Controllers\Auth\RegisterController::class, 'index']);
            Route::post('/', [\App\Http\Controllers\Auth\RegisterController::class, 'store'])->name('.store');
        });
    });
    // logout
    Route::group(['middleware' => 'auth'], function () {
        Route::get('logout', [\App\Http\Controllers\Client\UserController::class, 'logout'])->name('logout');
    });
});

// Verification email

Route::group(['middleware' => 'auth', 'as' => 'verification.', 'prefix' => 'email','namespace' => "\App\Http\Controllers"], function () {
    Route::get('/verify/{id}/{hash}', [EmailController::class, 'verify'])->middleware('signed')->name('verify');
    Route::get('/verify', [EmailController::class, 'notice'])->name('notice');
    Route::post('/verification-notification', [EmailController::class, 'send'])->middleware('throttle:6,1')->name('send');
});


// Client side

Route::get('/', [\App\Http\Controllers\Client\HomeController::class, 'index'])->name('home');
Route::get('/test/mail/message', [\App\Http\Controllers\TestController::class, 'test']);
Route::get('/about', [\App\Http\Controllers\Client\HomeController::class, 'about'])->name('about');

Route::resource('posts', \App\Http\Controllers\Client\PostController::class);
Route::resource('tracks', \App\Http\Controllers\Client\TrackController::class);
Route::resource('tracks.blocks', \App\Http\Controllers\Client\BlockController::class);
Route::resource('blocks.exercises', \App\Http\Controllers\Client\ExerciseController::class);

// todo: Сделать пути которые будут защищены от пользователей которые не подтвердили почту, middleware:verified


// todo: telegram webhook
Route::get('/make/webhook', function () {
    $http = Http::get('https://api.tlgr.org/bot5501374509:AAGa1MExGsrVvHVrALYiYeym0ww5rbiBYcQ/setWebhook?url=https://6985-176-96-82-145.eu.ngrok.io/webhook');
    dd($http->body());
});

Route::post('/webhook', [\App\Http\Controllers\TelegramController::class, 'index']);
