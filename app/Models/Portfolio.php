<?php

namespace App\Models;

use Database\Factories\PortfolioFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    /** @use HasFactory<PortfolioFactory> */
    use HasFactory;
}
