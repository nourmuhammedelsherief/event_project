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
        Schema::create('periods', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->unsignedBigInteger('date_id');
            $table->foreign('date_id')
                ->references('id')
                ->on('dates')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->time('start_at');
            $table->time('end_at');
            $table->integer('people_count')->default(0);
            $table->enum('status' , ['completed' , 'available' , 'closed'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periods');
    }
};
