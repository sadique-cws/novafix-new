<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_request_id')->constrained('service_requests')->onDelete('cascade');
            $table->decimal('amount', 8, 2);
            $table->decimal('discount', 8, 2)->default(0.00)->nullable();
            $table->decimal('tax', 8, 2)->default(0.00)->nullable();
            $table->decimal('total_amount', 8, 2)->nullable();
            $table->string('payment_method')->default('pending')->nullable(); 
            $table->string('transaction_id')->nullable(); 
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->foreignId('staff_id')->nullable()->constrained('staff')->onDelete('set null');
            $table->foreignId('received_by')->nullable()->constrained('receptioners')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
