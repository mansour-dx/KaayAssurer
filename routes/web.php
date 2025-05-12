<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PoliceController;
use App\Http\Controllers\SinistreController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\TypeAssuranceController;
use App\Http\Controllers\DashboardController;

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

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Routes pour les clients
Route::resource('clients', ClientController::class);

// Routes pour les polices d'assurance
Route::resource('polices', PoliceController::class);

// Routes pour les sinistres
Route::resource('sinistres', SinistreController::class);

// Routes pour les paiements
Route::resource('paiements', PaiementController::class);

// Routes pour les types d'assurance
Route::resource('type-assurances', TypeAssuranceController::class);

// Route optionnelle pour filtrer les sinistres par statut
Route::get('sinistres-status/{status}', [SinistreController::class, 'filterByStatus'])->name('sinistres.status');
