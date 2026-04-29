<?php

namespace App\Models;

use App\Traits\CastsStdClass;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portfolio extends Model
{
    use CastsStdClass, HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cashFlows(): HasMany
    {
        return $this->hasMany(CashFlow::class);
    }

    public function dividends(): HasMany
    {
        return $this->hasMany(Dividend::class);
    }

    public function tradeLogs(): HasMany
    {
        return $this->hasMany(TradeLog::class);
    }
}
