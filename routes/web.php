<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MailerLiteController;

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

Route::get('/', [HomeController::class, 'index']);
Route::post('/add_key', [HomeController::class, 'addKey']);
Route::get('/search', [MailerLiteController::class, 'search']);
Route::get('/delete/{id}', [MailerLiteController::class, 'delete']);
Route::get('/add-edit/{id}', [MailerLiteController::class, 'addEdit']);
Route::post('/save', [MailerLiteController::class, 'save']);


