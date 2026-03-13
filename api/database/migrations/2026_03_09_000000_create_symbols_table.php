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
        Schema::create('symbols', function (Blueprint $table) {
            $table->id();
            $table->string('ticker')->unique();
            $table->string('name');
            $table->string('symbol_type')->index();
            $table->string('market')->nullable();
            $table->string('locale')->nullable();
            $table->string('primary_exchange')->nullable();
            $table->string('currency_name')->nullable();
            $table->boolean('active')->default(true)->index();
            $table->string('cik')->nullable();
            $table->string('composite_figi')->nullable();
            $table->string('share_class_figi')->nullable();
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();

            $table->index(['symbol_type', 'active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('symbols');
    }
};
