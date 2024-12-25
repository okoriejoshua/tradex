<?php

namespace App\Http\Livewire\User;

use App\Models\Referral as ModelReferral;
use App\Http\Livewire\User\UserComponent;


class Referral extends UserComponent
{

    public $perPage = 15;
    public $referrals;

    public function render()
    {
        $this->referrals = ModelReferral::with('referredUser')->where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->offset(($this->page - 1) * $this->perPage)
            ->limit($this->perPage)
            ->get(); 
        return view('livewire.user.referral', ['referrals' => $this->referrals]);
    }

    public function loadMore()
    {
        $this->page++;
    }
}
