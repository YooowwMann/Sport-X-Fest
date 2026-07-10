<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventPublicController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\ActivityLogController;

Route::get('/', fn() => redirect('/home'));

// ─── Halaman Profil Tim ───────────────────────────────────────
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

// ─── Halaman Publik (dari Najwa-Event) ───────────────────────
Route::get('/home', [EventPublicController::class, 'home'])->name('home');
Route::get('/events-list', [EventPublicController::class, 'index'])->name('events.public');
Route::get('/dokumentasi', [EventPublicController::class, 'dokumentasi'])->name('dokumentasi');
Route::get('/contact', [EventPublicController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Pendaftaran event (harus login)
Route::middleware('auth')->group(function () {
    Route::get('/daftar', [EventPublicController::class, 'daftar'])->name('daftar');
    Route::post('/proses-daftar', [EventPublicController::class, 'prosesDaftar'])->name('proses_daftar');
});
Route::middleware('guest')->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', fn() => view('auth.register'))->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ─── Authenticated User Routes ───────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// ─── Admin Routes ─────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.role');
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Events
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    // Registrations
    Route::get('/registrations', [RegistrationController::class, 'index'])->name('registrations.index');
    Route::patch('/registrations/{registration}/approve', [RegistrationController::class, 'approve'])->name('registrations.approve');
    Route::patch('/registrations/{registration}/reject', [RegistrationController::class, 'reject'])->name('registrations.reject');

    // Activity Logs
    Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs.index');

    // Contact Inbox
    Route::get('/contact', [ContactController::class, 'index'])->name('contacts.index');
    Route::delete('/contact/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

    // Documentation Gallery
    Route::get('/dokumentasi', [GalleryController::class, 'index'])->name('dokumentasi.index');
    Route::post('/dokumentasi', [GalleryController::class, 'store'])->name('dokumentasi.store');
    Route::get('/dokumentasi/{galleryPhoto}/edit', [GalleryController::class, 'edit'])->name('dokumentasi.edit');
    Route::put('/dokumentasi/{galleryPhoto}', [GalleryController::class, 'update'])->name('dokumentasi.update');
    Route::delete('/dokumentasi/{galleryPhoto}', [GalleryController::class, 'destroy'])->name('dokumentasi.destroy');
});
