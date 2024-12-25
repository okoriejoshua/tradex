<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'payment_id',
        'asset',
        'amount',
        'asset_value',
        'duration',
        'status',
        'destination',
        'network',
        'transaction_id',
        'pop',
        'qrcode',
        'paymethod',
        'steps',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
