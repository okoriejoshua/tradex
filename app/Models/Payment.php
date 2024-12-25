<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'account_name',
        'account_number',
        'bank_name',
        'type',
        'note',
        'is_default',
        'is_active',
    ];

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
