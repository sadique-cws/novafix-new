<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add customer_id to service_requests
        Schema::table('service_requests', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->after('shop_id')->constrained('customers')->nullOnDelete();
        });

        // 2. Add balance to shops and customers
        Schema::table('shops', function (Blueprint $table) {
            $table->decimal('balance', 10, 2)->default(0)->after('gst_number');
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->decimal('balance', 10, 2)->default(0)->after('email');
        });

        // 3. Create ledgers table
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('franchise_id')->constrained()->onDelete('cascade');
            $table->foreignId('shop_id')->nullable()->constrained('shops')->onDelete('cascade');
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('cascade');
            $table->foreignId('service_request_id')->nullable()->constrained('service_requests')->onDelete('cascade');
            
            $table->enum('type', ['debit', 'credit']); // debit = increases due, credit = decreases due
            $table->decimal('amount', 10, 2);
            $table->string('description')->nullable();
            
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
        });

        // 4. Data Migration
        // First, link existing service_requests to customers if not a shop
        $serviceRequests = DB::table('service_requests')->get();
        foreach ($serviceRequests as $sr) {
            if (!$sr->is_shop) {
                $customer = DB::table('customers')
                    ->where('contact', $sr->contact)
                    ->where('franchise_id', $sr->franchise_id)
                    ->first();
                
                if (!$customer) {
                    $customerId = DB::table('customers')->insertGetId([
                        'franchise_id' => $sr->franchise_id ?? 1,
                        'name' => $sr->owner_name,
                        'contact' => $sr->contact,
                        'email' => $sr->email,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    $customerId = $customer->id;
                }

                DB::table('service_requests')->where('id', $sr->id)->update(['customer_id' => $customerId]);
            }
        }

        // Migrate Payments to Ledgers (Debits)
        $payments = DB::table('payments')->get();
        foreach ($payments as $payment) {
            if ($payment->total_amount > 0) {
                $sr = DB::table('service_requests')->where('id', $payment->service_request_id)->first();
                if ($sr) {
                    DB::table('ledgers')->insert([
                        'franchise_id' => $sr->franchise_id ?? 1,
                        'shop_id' => $sr->is_shop ? $sr->shop_id : null,
                        'customer_id' => !$sr->is_shop ? $sr->customer_id : null,
                        'service_request_id' => $sr->id,
                        'type' => 'debit',
                        'amount' => $payment->total_amount,
                        'description' => 'Final Bill for Service ' . $sr->service_code,
                        'created_at' => $payment->created_at ?? now(),
                        'updated_at' => $payment->updated_at ?? now(),
                    ]);
                }
            }
        }

        // Migrate Payment Transactions to Ledgers (Credits)
        $transactions = DB::table('payment_transactions')->get();
        foreach ($transactions as $txn) {
            $sr = DB::table('service_requests')->where('id', $txn->service_request_id)->first();
            if ($sr) {
                DB::table('ledgers')->insert([
                    'franchise_id' => $sr->franchise_id ?? 1,
                    'shop_id' => $sr->is_shop ? $sr->shop_id : null,
                    'customer_id' => !$sr->is_shop ? $sr->customer_id : null,
                    'service_request_id' => $sr->id,
                    'type' => 'credit',
                    'amount' => $txn->amount_paid,
                    'description' => 'Payment Received: ' . ($txn->notes ?? 'Cash'),
                    'created_at' => $txn->created_at ?? now(),
                    'updated_at' => $txn->updated_at ?? now(),
                ]);
            }
        }

        // Calculate and set initial balances
        $shops = DB::table('shops')->get();
        foreach ($shops as $shop) {
            $debits = DB::table('ledgers')->where('shop_id', $shop->id)->where('type', 'debit')->sum('amount');
            $credits = DB::table('ledgers')->where('shop_id', $shop->id)->where('type', 'credit')->sum('amount');
            DB::table('shops')->where('id', $shop->id)->update(['balance' => $debits - $credits]);
        }

        $customers = DB::table('customers')->get();
        foreach ($customers as $customer) {
            $debits = DB::table('ledgers')->where('customer_id', $customer->id)->where('type', 'debit')->sum('amount');
            $credits = DB::table('ledgers')->where('customer_id', $customer->id)->where('type', 'credit')->sum('amount');
            DB::table('customers')->where('id', $customer->id)->update(['balance' => $debits - $credits]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ledgers');
        
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn('balance');
        });
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('balance');
        });
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
        });
    }
};
