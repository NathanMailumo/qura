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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_id')->constrained()->onDelete('cascade'); 
            $table->string('name');
            $table->string('code')->nullable(); 
            $table->string('location'); 
            $table->string('icon_type')->default('general'); 
            $table->integer('patients_ahead')->default(0);
            $table->integer('avg_wait_time_mins')->default(15);
            $table->enum('wait_status', ['Low Wait', 'Moderate', 'High Wait'])->default('Low Wait');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
