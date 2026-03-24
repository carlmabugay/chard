<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trade_logs', function (Blueprint $table) {

            $table->foreignId('portfolio_id')->constrained();

            $table->id();
            $table->string('symbol');
            $table->enum('type', ['buy', 'sell'])->default('buy');
            $table->float('price', 8, 2)->default(0);
            $table->integer('shares')->default(0);
            $table->float('fees', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_logs');
    }
};
