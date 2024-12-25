<?php

namespace App\Http\Livewire\User;

use App\Http\Livewire\User\UserComponent;
use App\Models\Transaction;
use Carbon\Carbon;

class Transactions extends UserComponent
{
    public $perPage = 15;
    public $usertransactions;
    public $details;


    public function hydrate()
    {
        $this->checkExpirations();
    }

    public function render()
    {
        $this->usertransactions = Transaction::query()
            ->select('transactions.*', 'coins.icon', 'coins.name', 'coins.symbol')
            ->join('coins', 'coins.symbol', '=', 'transactions.asset')
            ->where('transactions.user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->offset(($this->page - 1) * $this->perPage)
            ->limit($this->perPage)
            ->get();

        return view('livewire.user.transactions', [
            'transactions' => $this->usertransactions,
            'details' => $this->details,
        ]);
    } 

    public function loadMore()
    {
        $this->page++;
    }

    public function getDetails($id)
    {
        $this->details = $this->usertransactions->where('id', $id)->first();
        $this->open('transactionDetails');
    }


    private function checkExpirations()
    {
        $expiredTransactions = Transaction::where('status', 'waiting for pop')
        ->where('duration', '<', Carbon::now())
            ->get();

        foreach ($expiredTransactions as $transaction) {
            $transaction->status = 'expired';
            $transaction->save();
        }
    }
}
