
<?php

use App\Http\Livewire\User\Activity;
use App\Http\Livewire\User\Dashboard;
use App\Http\Livewire\User\Payments;
use App\Http\Livewire\User\Profile;
use App\Http\Livewire\User\Referral;
use App\Http\Livewire\User\Support;
use App\Http\Livewire\User\Transactions;
use Illuminate\Support\Facades\Route;



Route::prefix('user')->middleware(['auth', 'checkUser'])->group(function () {
    Route::get('dashboard', Dashboard::class)->name('user.dashboard');
    Route::get('profile/{autoshow?}', Profile::class)->name('user.profile');
    Route::get('transactions', Transactions::class)->name('user.transactions');
    Route::get('activities', Activity::class)->name('user.activities');
    Route::get('payment', Payments::class)->name('user.payment');
    Route::get('referral', Referral::class)->name('user.referral');
    Route::get('support', Support::class)->name('user.support');
});

