<div>
    <div class="min-h-screen bg-gray-100 py-8 px-4">
    <div class="receipt-container max-w-2xl mx-auto bg-white border border-gray-300 shadow-sm print:shadow-none">
        <div class="receipt p-6">
            <!-- Header -->
            <div class="header text-center border-b border-dashed border-gray-300 pb-4 mb-4">
                <h2 class="company-name text-2xl font-bold text-blue-600">NovaFix</h2>
                <p class="tagline italic text-gray-500 text-sm">Fixing Today, Securing Tomorrow!</p>
                <p class="receipt-number mt-2 text-sm font-semibold">Receipt Service Code: {{ $receipt->service_code }}</p>
            </div>

            <!-- Dual Column Layout for Customer and Franchise Info -->
            <div class="dual-info grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Customer Information -->
                <div class="customer-details bg-blue-50 p-3 rounded-lg border border-blue-200">
                    <h3 class="font-bold text-blue-700 text-sm mb-2 border-b border-blue-300 pb-1">CUSTOMER DETAILS</h3>
                    <p class="text-xs mb-1"><strong>Name:</strong> {{ $receipt->owner_name }}</p>
                    <p class="text-xs mb-1"><strong>Contact:</strong> {{ $receipt->contact }}</p>
                    <p class="text-xs mb-0"><strong>Email:</strong> {{ $receipt->email ?? 'N/A' }}</p>
                    <p class="text-xs mb-1">
                        <strong>Receipt Date:</strong> {{ $receipt->created_at->setTimezone('Asia/Kolkata')->format('d-m-Y, h:i A') }}
                    </p>
                </div>

                <!-- Franchise Information -->
                <div class="franchise-details bg-green-50 p-3 rounded-lg border border-green-200">
                    <h3 class="font-bold text-green-700 text-sm mb-2 border-b border-green-300 pb-1">BRANCH DETAILS</h3>
                    <p class="text-xs mb-1"><strong>Branch Name:</strong> {{ $receipt->franchise->franchise_name ?? 'N/A' }}</p>
                    <p class="text-xs mb-1"><strong>Address:</strong> {{ $receipt->franchise->street ?? 'N/A' }}</p>
                    <p class="text-xs mb-1"><strong>Location:</strong> {{ $receipt->franchise->district ?? 'N/A' }},
                        {{ $receipt->franchise->state ?? 'N/A' }} - {{ $receipt->franchise->pincode ?? 'N/A' }}</p>
                    <p class="text-xs mb-0"><strong>Contact:</strong> {{ $receipt->franchise->contact_no ?? 'N/A' }} |
                        {{ $receipt->franchise->email ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Device Details Table -->
            <table class="details-table w-full border-collapse mb-4 text-xs">
                <tr>
                    <td class="font-bold bg-gray-50 border border-gray-300 p-2 w-1/4">Device Name</td>
                    <td class="border border-gray-300 p-2">{{ strtoupper($receipt->product_name) }}</td>
                    <td class="font-bold bg-gray-50 border border-gray-300 p-2 w-1/4">Service Code</td>
                    <td class="border border-gray-300 p-2">{{ $receipt->service_code }}</td>
                </tr>
                <tr>
                    <td class="font-bold bg-gray-50 border border-gray-300 p-2">Problem Reported</td>
                    <td class="border border-gray-300 p-2">{{ strtoupper($receipt->problem) }}</td>
                    <td class="font-bold bg-gray-50 border border-gray-300 p-2">Brand</td>
                    <td class="border border-gray-300 p-2">{{ strtoupper($receipt->brand) }}</td>
                </tr>
                <tr>
                    <td class="font-bold bg-gray-50 border border-gray-300 p-2">Service Category</td>
                    <td class="border border-gray-300 p-2">{{ strtoupper($receipt->serviceCategory->name ?? 'N/A') }}</td>
                    <td class="font-bold bg-gray-50 border border-gray-300 p-2">Serial Number</td>
                    <td class="border border-gray-300 p-2">{{ $receipt->serial_no ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="font-bold bg-gray-50 border border-gray-300 p-2">Color</td>
                    <td class="border border-gray-300 p-2">{{ strtoupper($receipt->color) }}</td>
                    <td class="font-bold bg-gray-50 border border-gray-300 p-2">Est. Delivery</td>
                    <td class="border border-gray-300 p-2">
                        {{ \Carbon\Carbon::parse($receipt->estimate_delivery)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td class="font-bold bg-gray-50 border border-gray-300 p-2">Model No</td>
                    <td class="border border-gray-300 p-2">{{ $receipt->product_name }}</td>
                    <td class="font-bold bg-gray-50 border border-gray-300 p-2">Status</td>
                    <td class="border border-gray-300 p-2">{{ $statusText }}</td>
                </tr>
                @if ($receipt->remark)
                    <tr>
                        <td class="font-bold bg-gray-50 border border-gray-300 p-2">Remark</td>
                        <td class="border border-gray-300 p-2" colspan="3">{{ $receipt->remark }}</td>
                    </tr>
                @endif
            </table>

            <!-- Payment Summary -->
            @if (isset($payment))
                <div class="payment-summary bg-blue-50 rounded-lg p-4 mb-4 border border-blue-200">
                    <h3 class="text-center font-bold mb-3 text-sm text-blue-700">PAYMENT SUMMARY</h3>
                    <div class="payment-row flex justify-between py-1 text-xs">
                        <span>Service Amount:</span>
                        <span>₹{{ number_format($payment->amount ?? 0, 2) }}</span>
                    </div>
                    <div class="payment-row flex justify-between py-1 text-xs">
                        <span>Discount:</span>
                        <span>- ₹{{ number_format($payment->discount ?? 0, 2) }}</span>
                    </div>
                    <div class="payment-row flex justify-between py-1 text-xs">
                        <span>Tax ({{ $payment->tax > 0 ? round(($payment->tax / $payment->amount) * 100, 2) : 0 }}%):</span>
                        <span>+ ₹{{ number_format($payment->tax ?? 0, 2) }}</span>
                    </div>
                    <div class="payment-row flex justify-between border-t border-gray-300 pt-2 mt-2 font-bold text-sm">
                        <span>TOTAL AMOUNT:</span>
                        <span>₹{{ number_format($payment->total_amount ?? 0, 2) }}</span>
                    </div>
                    @if ($payment->notes)
                        <div class="payment-notes mt-3 pt-2 border-t border-dashed border-blue-300 text-xs">
                            <p><strong>Notes:</strong> {{ $payment->notes }}</p>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Thank You Message -->
            <p class="thank-you text-center italic mb-4 text-sm text-gray-600">
                Thank you for choosing NovaFix. We appreciate your trust in our service!
            </p>

             <div class="terms bg-gray-50 rounded-lg p-4 mb-4 border border-gray-200">
                <strong class="text-sm">Terms & Conditions:</strong>
                <ol class="list-decimal pl-5 mt-2 space-y-1 text-xs">
                    <li>We will not be responsible if the product is not taken back within 30 days.</li>
                    <li>Please confirm by phone before collecting your product.</li>
                    <li>Warranty applies only to GST-included repairs.</li>
                    <li>Rs. 350 checking fee applies if not repaired or repair declined.</li>
                </ol>
            </div>

            <!-- Signature -->
            <p class="signature text-right mt-6 pt-2 border-t border-dashed border-gray-300 text-sm font-bold">
                Authorized Sign & Stamp
            </p>

            <!-- Footer -->
            <div class="footer text-center mt-4 pt-3 border-t border-dashed border-gray-300">
                <p class="text-xs text-gray-500">Generated on: {{ now()->format('d-m-Y, h:i A') }}</p>
                <p class="text-xs text-gray-500">Computer-generated receipt. No signature required.</p>
            </div>
        </div>

        <!-- Print Button -->
        <div class="no-print text-center mb-2">
            <button wire:click="printReceipt"
                class="print-btn bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                Print Receipt
            </button>
        </div>
    </div>
</div>

<!-- PRINT STYLES -->
<style>
    @media print {
        body {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            zoom: 90%; /* Scale down slightly if content overflows */
        }

        .no-print {
            display: none !important;
        }

        .receipt-container {
            page-break-before: avoid;
            page-break-after: avoid;
            page-break-inside: avoid;
            overflow: hidden !important;
        }

        .receipt {
            page-break-before: avoid;
            page-break-after: avoid;
            page-break-inside: avoid;
        }

        @page {
            size: A4;
            margin: 10mm;
        }
    }
</style>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('printReceipt', () => {
            window.print();
        });
    });
</script>

</div>