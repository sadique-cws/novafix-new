<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->boolean('is_shop')->default(false)->after('franchise_id');
            $table->foreignId('shop_id')->nullable()->after('is_shop')->constrained('shops')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropForeign(['shop_id']);
            $table->dropColumn(['is_shop', 'shop_id']);
        });
    }
};
