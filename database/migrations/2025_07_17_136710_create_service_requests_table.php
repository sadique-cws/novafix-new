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
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receptioners_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('technician_id')->nullable()->constrained("staff")->onDelete('cascade');
            $table->foreignId('franchise_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('service_categories_id')->constrained()->onDelete('cascade');
            $table->string('service_code');
            $table->string('serial_no')->nullable();
            $table->string('owner_name');
            $table->string('product_name');
            $table->string('email')->nullable();
            $table->string('contact');
            $table->string('brand');
            $table->string('color');
            $table->decimal('service_amount', 8, 2)->nullable();
            $table->string('problem');
            $table->string('remark')->nullable();
            $table->double('status', 8, 2)->default(0.00);
            $table->dateTime('last_update')->nullable();
            $table->string('delivered_by')->nullable();
            $table->boolean('delivery_status')->default(false);
            $table->dateTime('estimate_delivery')->nullable();
            $table->timestamps(); // created_at and updated_at
            $table->string('image_url')->nullable();
            $table->string('image_file_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
