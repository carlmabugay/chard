<?php

namespace App\Models;

use Database\Factories\TradeLogFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradeLog extends Model
{
    /** @use HasFactory<TradeLogFactory> */
    use HasFactory;

    protected $fillable = [
        'portfolio_id',
        'symbol',
        'type',
        'price',
        'shares',
        'fees',
    ];

    protected $casts = [
        'price' => 'float',
        'shares' => 'integer',
        'fees' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
