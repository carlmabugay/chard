<?php

namespace App\Models;

use Database\Factories\DividendFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dividend extends Model
{
    /** @use HasFactory<DividendFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'portfolio_id',
        'symbol',
        'amount',
    ];

    protected $casts = [
        'amount' => 'float',
        'recorded_at' => 'datetime',
    ];

    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }
}
