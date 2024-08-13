<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->foreignId('company_id')
                ->nullable()
                ->index()
                ->constrained()
                ->cascadeOnDelete();

            $table->unique([
                'company_id',
                'slug'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropUnique([
                'company_id',
                'slug'
            ]);

            $table->dropConstrainedForeignId('company_id');
        });
    }
};