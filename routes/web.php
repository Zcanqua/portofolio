
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PortfolioController;

Route::get('/', PortfolioController::class)->name('home');

Route::view('/contact', 'contact')->name('contact');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->middleware('throttle:5,1')->name('authenticate');

    Route::middleware('admin.auth')->group(function () {
        Route::get('/projects', [AdminController::class, 'index'])->name('projects.index');
        Route::post('/profile/photo', [AdminController::class, 'updateProfilePhoto'])->name('profile.photo');
        Route::post('/certificates', [AdminController::class, 'storeCertificate'])->name('certificates.store');
        Route::put('/certificates/{id}', [AdminController::class, 'updateCertificate'])->name('certificates.update');
        Route::delete('/certificates/{id}', [AdminController::class, 'destroyCertificate'])->name('certificates.destroy');
        Route::post('/projects', [AdminController::class, 'store'])->name('projects.store');
        Route::put('/projects/{id}', [AdminController::class, 'update'])->name('projects.update');
        Route::delete('/projects/{id}', [AdminController::class, 'destroy'])->name('projects.destroy');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    });
});
