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
        Schema::create('receptioners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('franchise_id')->nullable();
            $table->string('name');
            $table->string('contact');
            $table->string('email');
            $table->string('aadhar');
            $table->string('pan');
            $table->string('address');
            $table->string('salary');
            $table->string('status')->default('1');
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receptioners');
    }
};
