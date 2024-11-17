<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::put('/profile/update-skin-type', [ProfileController::class, 'updateSkinType'])->name('profile.update-skin-type');

    Route::post('/profile/allergens', [ProfileController::class, 'addAllergens'])->name('profile.add-allergens');
    Route::delete('/profile/allergens/{allergen}', [ProfileController::class, 'deleteAllergen'])->name('profile.delete-allergen');
});

require __DIR__.'/auth.php';
