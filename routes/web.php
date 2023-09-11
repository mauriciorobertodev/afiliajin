<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin'       => Route::has('login'),
        'canRegister'    => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion'     => PHP_VERSION,
    ]);
});

Route::get('/dashboard', fn () => Inertia::render('Dashboard'))->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/paginas', [PageController::class, 'index'])->name('page.index');
    Route::get('/paginas/nova', [PageController::class, 'create'])->name('page.create');
    Route::post('/paginas/nova', [PageController::class, 'store'])->name('page.store');
    Route::get('/paginas/editar/{id}', [PageController::class, 'edit'])->name('page.edit');
    Route::put('/paginas/editar/{id}', [PageController::class, 'update'])->name('page.update');
    Route::put('/paginas/editar/links/{id}', [PageController::class, 'updateLinks'])->name('page.update.links');
    Route::put('/paginas/editar/body/{id}', [PageController::class, 'updateBody'])->name('page.update.body');
    Route::delete('/paginas/excluir/{id}', [PageController::class, 'destroy'])->name('page.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');
