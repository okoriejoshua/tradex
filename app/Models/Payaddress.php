<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payaddress extends Model
{
    use HasFactory;
    protected $fillable = ['coin_id', 'network', 'address', 'blockchain', 'qr', 'status'];

    public function coin()
    {
        return $this->belongsTo(Coin::class);
    }
}
