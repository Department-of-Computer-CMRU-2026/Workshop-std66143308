<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('dashboard', \App\Livewire\Dashboard::class)->name('dashboard');
});

require __DIR__ . '/settings.php';

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::livewire('dashboard', 'admin.dashboard')->name('dashboard');
    Route::livewire('events', 'admin.event.index')->name('events.index');
    Route::livewire('events/create', 'admin.event.create')->name('events.create');
    Route::livewire('events/{event}/edit', 'admin.event.edit')->name('events.edit');
});
