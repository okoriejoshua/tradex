<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'icon',
        'symbol',
        'rate',
        'minimum',
        'status',
    ];

   /* public function payaddresses()
    {
        return $this->hasMany(Payaddress::class);
    }*/

    public function payaddress() 
    {
        return $this->hasOne(Payaddress::class); 
    }
}
