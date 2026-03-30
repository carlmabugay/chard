<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TradeLog extends Model
{
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

    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }
}
