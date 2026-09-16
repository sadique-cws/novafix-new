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
        // 1. Create the new table for individual payment transactions
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained('payments')->onDelete('cascade');
            $table->foreignId('service_request_id')->constrained('service_requests')->onDelete('cascade');
            $table->decimal('amount_paid', 10, 2);
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->foreignId('received_by')->nullable()->constrained('receptioners')->onDelete('set null');
            $table->foreignId('staff_id')->nullable()->constrained('staff')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 2. Add 'paid_amount' and 'due_amount' to the 'payments' table
        Schema::table('payments', function (Blueprint $table) {
            $table->decimal('paid_amount', 10, 2)->default(0)->after('total_amount');
            $table->decimal('due_amount', 10, 2)->default(0)->after('paid_amount');
        });

        // 3. Migrate Data: Read existing payments and copy into payment_transactions
        // We must iterate through ALL service requests to ensure we don't lose the legacy service_amount
        $serviceRequests = DB::table('service_requests')->get();
        foreach ($serviceRequests as $sr) {
            $payment = DB::table('payments')->where('service_request_id', $sr->id)->first();
            
            if (!$payment) {
                // If no payment record exists (e.g. pending task), create one using the legacy service_amount
                $billAmount = $sr->service_amount ?? 0;
                DB::table('payments')->insert([
                    'service_request_id' => $sr->id,
                    'amount' => $billAmount,
                    'total_amount' => $billAmount,
                    'paid_amount' => 0,
                    'due_amount' => $billAmount,
                    'status' => 'pending',
                    'created_at' => $sr->created_at,
                    'updated_at' => $sr->updated_at,
                ]);
            } else {
                // Payment record exists, calculate its due/paid amounts and create a transaction if completed
                $paid = 0;
                $due = $payment->total_amount;
                
                if (strtolower($payment->status) === 'completed') {
                    $paid = $payment->total_amount;
                    $due = 0;

                    DB::table('payment_transactions')->insert([
                        'payment_id' => $payment->id,
                        'service_request_id' => $payment->service_request_id,
                        'amount_paid' => $paid,
                        'payment_method' => $payment->payment_method ?? 'cash',
                        'transaction_id' => $payment->transaction_id,
                        'received_by' => $payment->received_by,
                        'staff_id' => $payment->staff_id,
                        'notes' => 'Migrated from legacy payment record.',
                        'created_at' => $payment->created_at,
                        'updated_at' => $payment->updated_at,
                    ]);
                }

                $newStatus = 'pending';
                if ($paid > 0 && $due > 0) {
                    $newStatus = 'partial';
                } elseif ($due <= 0) {
                    $newStatus = 'completed';
                }

                DB::table('payments')->where('id', $payment->id)->update([
                    'paid_amount' => $paid,
                    'due_amount' => $due,
                    'status' => $newStatus
                ]);
            }
        }

        // 4. Drop the old service_amount column from service_requests to avoid confusion
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn('service_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->decimal('service_amount', 10, 2)->nullable();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['paid_amount', 'due_amount']);
        });

        Schema::dropIfExists('payment_transactions');
    }
};
