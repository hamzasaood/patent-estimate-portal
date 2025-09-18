<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\QuotesController;
use App\Http\Controllers\Admin\PricingLogicController;
use App\Http\Controllers\Admin\PricingLevelController;



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

Route::post('/contact/us',function(){
    

    
})->name('contact.send');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth','admin'])->prefix('admin')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('admin.dashboard');
    Route::get('dashboard/data', [QuotesController::class,'data'])->name('admin.dashboard.data');
    Route::resource('quotes', QuotesController::class);

    Route::resource('pricing-logics', PricingLogicController::class);

    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);

    Route::resource('pricing-levels', PricingLevelController::class);
});

Route::get('/api/wipo/{appNo}', function($appNo){
    $wipo = new \App\Services\WipoService;
    return response()->json($wipo->fetchByApplication($appNo));
});

// routes/web.php
Route::get('/wipo/real/fetch/{appNo}', [App\Http\Controllers\WipoController::class, 'fetch']);


Route::get('/wipo/fetch/{application_number}', [QuoteController::class, 'fetchWipo']);
Route::get('/epo/fetch/{application_number}', [QuoteController::class, 'fetchEpo']);


Route::get('/quotes/all', [QuoteController::class, 'index'])->name('quotes.index')->middleware('auth');
Route::get('/quick/quotes/create', [QuoteController::class, 'create'])->name('quotes.create.quick');
Route::post('/quick/quotes', [QuoteController::class, 'store'])->name('quotes.store.quick');
Route::get('/quick/{quote}', [QuoteController::class, 'show'])->name('quotes.show.quick');

Route::get('/quotes/{quote}/download', [App\Http\Controllers\QuoteController::class, 'download'])
     ->name('quotes.download');


     Route::post('/quotes/prepay', [QuoteController::class, 'prepay'])->name('quotes.prepay');
Route::get('/quotes/payment/success/{quote}', [QuoteController::class, 'paymentSuccess'])->name('quotes.payment.success');
Route::get('/quotes/payment/cancel/{quote}', [QuoteController::class, 'paymentCancel'])->name('quotes.payment.cancel');


// routes/web.php
Route::get('/wipo/fetch/{application_number}', [App\Http\Controllers\WipoController::class, 'fetch']);

