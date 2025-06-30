<?php

use App\Http\Controllers\SupportRequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GmailController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');


Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('support-requests',[SupportRequestController::class,'index'])->name('support-requests.index');    

    //gmail
    Route::get('/gmail', [GmailController::class, 'index'])->name('gmail.index');
    Route::get('/gmail/authorize', [GmailController::class, 'authorize'])->name('gmail.authorize');
    Route::get('/auth/gmail/callback', [GmailController::class, 'callback'])->name('gmail.callback');
    Route::get('/gmail/search', [GmailController::class, 'search'])->name('gmail.search');
    Route::post('/gmail/disconnect', [GmailController::class, 'disconnect'])->name('gmail.disconnect');
});




require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
