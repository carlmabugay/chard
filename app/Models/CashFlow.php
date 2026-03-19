<?php

namespace App\Models;

use Database\Factories\CashFlowFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashFlow extends Model
{
    /** @use HasFactory<CashFlowFactory> */
    use HasFactory;

    protected $fillable = [
        'type',
        'amount',
    ];
}
