<?php

namespace App\Models;

use App\Enums\CashFlowType;
use Database\Factories\CashFlowFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashFlow extends Model
{
    /** @use HasFactory<CashFlowFactory> */
    use HasFactory;

    protected $fillable = [
        'portfolio_id',
        'type',
        'amount',
        'id',
    ];

    protected $casts = [
        'type' => CashFlowType::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }
}
