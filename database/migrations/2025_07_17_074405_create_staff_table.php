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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('franchise_id')->nullable()->constrained("franchises")->onDelete('set null');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('contact');
            $table->string('salary');
            $table->foreignId('service_categories_id')->constrained()->onDelete('cascade');
            $table->string('status');
            $table->string('image')->nullable();
            $table->string('aadhar');
            $table->string('pan');
            $table->string('address');
            $table->string('password');
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
