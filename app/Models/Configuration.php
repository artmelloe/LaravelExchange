<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory, Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'boleto_fee',
        'credit_card_fee',
        'fee_amount_less',
        'fee_amount_less_value',
        'fee_amount_greater',
        'fee_amount_greater_value'
    ];
}
