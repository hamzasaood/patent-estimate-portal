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




Route::view('/', 'home');
Route::view('/about', 'about');
Route::view('/solutions', 'solutions');
Route::view('/resources', 'resources');
Route::view('/contact', 'contact');

Route::view('/quotes/create', 'quotes.create');
Route::view('/admin/quotes', 'admin.quotes.index');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth','admin'])->group(function () {
    Route::view('/admin', 'admin.dashboard')->name('admin.dashboard');
    Route::view('/admin/quotes', 'admin.quotes.index')->name('admin.quotes.index');
});

Route::get('/api/wipo/{appNo}', function($appNo){
    $wipo = new \App\Services\WipoService;
    return response()->json($wipo->fetchByApplication($appNo));
});


use App\Http\Controllers\QuoteController;

Route::get('/quotes/create', [QuoteController::class, 'create'])->name('quotes.create');
Route::post('/quotes', [QuoteController::class, 'store'])->name('quotes.store');
Route::get('/quotes/{quote}', [QuoteController::class, 'show'])->name('quotes.show');

