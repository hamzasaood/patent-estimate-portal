<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\QuotesController;
use App\Http\Controllers\Admin\PricingLogicController;

use App\Http\Controllers\QuoteController;




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
//Route::view('/admin/quotes', 'admin.quotes.index');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth','admin'])->prefix('admin')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('admin.dashboard');
    Route::get('dashboard/data', [QuotesController::class,'data'])->name('admin.dashboard.data');
    Route::resource('quotes', QuotesController::class);

    Route::resource('pricing', PricingLogicController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
});

Route::get('/api/wipo/{appNo}', function($appNo){
    $wipo = new \App\Services\WipoService;
    return response()->json($wipo->fetchByApplication($appNo));
});



Route::get('/quick/quotes/create', [QuoteController::class, 'create'])->name('quotes.create.quick');
Route::post('/quick/quotes', [QuoteController::class, 'store'])->name('quotes.store.quick');
Route::get('/quick/{quote}', [QuoteController::class, 'show'])->name('quotes.show.quick');

Route::get('/quotes/{quote}/download', [App\Http\Controllers\QuoteController::class, 'download'])
     ->name('quotes.download');


// routes/web.php
Route::get('/wipo/fetch/{application_number}', [App\Http\Controllers\WipoController::class, 'fetch']);

