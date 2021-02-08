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

Route::get('/', [
    'uses' => 'App\Http\Controllers\NoteController@getUserNotes',
    'as' => 'home'
])->middleware('auth');

Route::get('/edit/{id}', [
    'uses' => 'App\Http\Controllers\NoteController@getNote',
    'as' => 'edit'
])->middleware('auth');

Route::post('/update', [
    'uses' => 'App\Http\Controllers\NoteController@editNote',
    'as' => 'update'
])->middleware('auth');

Route::get('/new', function () {
    return view('new');
})->middleware('auth')->name('new');

Route::post('/new', [
    'uses' => 'App\Http\Controllers\NoteController@postNote',
    'as' => 'postNew'
])->middleware('auth');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
