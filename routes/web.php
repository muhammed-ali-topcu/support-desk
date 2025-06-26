<?php

use App\Http\Controllers\SupportRequestController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');


Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('support-requests',[SupportRequestController::class,'index'])->name('support-requests.index');    
});



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
