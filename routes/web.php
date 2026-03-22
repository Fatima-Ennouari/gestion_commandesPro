<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommandeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('commandes.index');
});

Route::get('/dashboard', function () {
    return redirect()->route('commandes.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('commandes', CommandeController::class);
    Route::get('commandes/{commande}/confirm-delete', [CommandeController::class, 'confirmDelete'])->name('commandes.confirm-delete');
    Route::post('commandes/{commande}/add-products', [CommandeController::class, 'addProducts'])->name('commandes.add-products');
    Route::get('statistiques', [CommandeController::class, 'statistiques'])->name('statistiques');
});

require __DIR__.'/auth.php';
