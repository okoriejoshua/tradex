<?php

use App\Http\Livewire\Admin\ListUsers;
use App\Http\Livewire\Admin\AdminDashboard;
use App\Http\Livewire\Admin\ListAdmins;
use App\Http\Livewire\Admin\ViewProfile;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth', 'checkUser'])->group(function () {
    Route::get('dashboard', AdminDashboard::class)->name('admin.dashboard');
    Route::get('users', ListUsers::class)->name('admin.users');
    Route::get('admins', ListAdmins::class)->name('admin.admins');
    Route::get('profile', ViewProfile::class)->name('admin.profile');
});
