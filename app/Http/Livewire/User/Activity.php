<?php

namespace App\Http\Livewire\User;

use App\Models\Activity as ModelsActivity;
use App\Http\Livewire\User\UserComponent;

class Activity extends UserComponent
{

    public $activities;
    public $perPage = 15;

    public function render()
    {
        $this->activities= ModelsActivity::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->offset(($this->page - 1) * $this->perPage)
            ->limit($this->perPage)
            ->get();
            

        return view('livewire.user.activity',['activities'=>$this->activities]);
    }

    public function loadMore()
    {
        $this->page++;
    }
}
