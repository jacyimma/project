<?php

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
    if(!Auth::id()) return redirect('/login');
    return view('welcome');
});

Auth::routes(); 

// Route::get('/home', 'HomeController@index')->name('home');
// Route::get('conversation/{userId}', 'MessageController@conversation')
//     ->name('message.conversation');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
Route::get('/conversation/{userId}', [App\Http\Controllers\MessageController::class, 'index'])->name('message.conversation');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('image-upload',  [App\Http\Controllers\HomeController::class, 'addPost'])->name('image.upload');
Route::get('/lang/{locale}', function ($locale){
    
    Session::put('locale', $locale);

    return redirect('/home');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
