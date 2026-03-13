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
        Schema::table('watchlist_items', function (Blueprint $table) {
            // Drop the old unique constraint
            $table->dropUnique(['watchlist_id', 'symbol']);

            // Drop the old symbol column
            $table->dropColumn('symbol');

            // Add the new symbol_id column with foreign key
            $table->foreignId('symbol_id')
                ->after('watchlist_id')
                ->constrained()
                ->cascadeOnDelete();

            // Add the new unique constraint
            $table->unique(['watchlist_id', 'symbol_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('watchlist_items', function (Blueprint $table) {
            // Drop the new unique constraint and foreign key
            $table->dropUnique(['watchlist_id', 'symbol_id']);
            $table->dropForeign(['symbol_id']);
            $table->dropColumn('symbol_id');

            // Restore the old symbol column
            $table->string('symbol', 20)->after('watchlist_id');

            // Restore the old unique constraint
            $table->unique(['watchlist_id', 'symbol']);
        });
    }
};
