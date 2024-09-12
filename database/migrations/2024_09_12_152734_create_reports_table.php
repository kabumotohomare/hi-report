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
        Schema::create('reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('category_id')
                ->constrained();
            $table->string('image');
            $table->float('latitude', 10, 7);
            $table->float('longitude', 10, 7);
            $table->text('detail');
            $table->string('email')->nullable();
            $table->string('contact')->nullable();
            $table->timestamp('reported_at')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
