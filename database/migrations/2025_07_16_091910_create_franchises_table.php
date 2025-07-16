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
        Schema::create('franchises', function (Blueprint $table) {
            $table->id();
            $table->string('franchise_name');
            $table->string('contact_no', 15);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('aadhar_no', 20)->nullable();
            $table->string('pan_no', 20)->nullable();
            $table->string('ifsc_code', 20)->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_no', 30)->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('pincode', 10)->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->date('doc')->comment('Date of Creation')->nullable();
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('franchises');
    }
};
