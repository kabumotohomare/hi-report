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
         Schema::create('report_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('report_id')
                ->constrained();
                //->references('id')
                //->on('reports');
            $table->foreignId('status_id')
                ->default(1)  // 受付前
                ->constrained();
            $table->foreignId('reason_id')
                ->nullable()
                ->constrained();
            $table->text('comment')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_status_histories');
    }
};
