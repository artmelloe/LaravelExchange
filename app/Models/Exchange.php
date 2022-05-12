<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    use HasFactory, Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'origin_currency',
        'income_currency',
        'amount_exchange',
        'payment_method',
        'current_currency',
        'exchange_total',
        'payment_fee',
        'exchange_fee',
        'exchange_without_fees'
    ];
}
