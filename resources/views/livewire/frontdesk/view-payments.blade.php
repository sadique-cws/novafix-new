<div>

    <div class="bg-gray-100 font-sans">
        <div class="receipt-container max-w-[180mm] mx-auto p-4 bg-white border print:shadow-none">
            <!-- Receipt Header -->
            <div class="receipt-header text-center border-b border-dashed border-gray-300 pb-2 mb-3">
                <h1 class="company-name text-2xl font-bold text-blue-500">NovaFix</h1>
                <p class="tagline italic text-gray-500 text-xs">Fixing Today, Securing Tomorrow!</p>
                <h2 class="receipt-title text-lg font-bold text-gray-800 mt-1">PAYMENT RECEIPT</h2>
                <p class="text-xs">Service Code: {{ $serviceRequest->service_code }}</p>
            </div>

            <!-- Customer Information -->
            <div class="customer-info grid grid-cols-1 sm:grid-cols-2 gap-2 mb-3">
                <div>
                    <div class="info-item mb-1">
                        <span class="info-label font-bold text-gray-600">Customer Name:</span>
                        {{ $serviceRequest->owner_name }}
                    </div>
                    <div class="info-item mb-1">
                        <span class="info-label font-bold text-gray-600">Contact:</span> {{ $serviceRequest->contact }}
                    </div>
                    <div class="info-item mb-1">
                        <span class="info-label font-bold text-gray-600">Email:</span>
                        {{ $serviceRequest->email ?? 'N/A' }}
                    </div>
                </div>
                <div>
                    <div class="info-item mb-1">
                        <span class="info-label font-bold text-gray-600">Receipt Date:</span>
                        {{ now()->format('d M Y, h:i A') }}
                    </div>
                    <div class="info-item mb-1">
                        <span class="info-label font-bold text-gray-600">Payment Status:</span>
                        <span class="status-badge inline-block px-1 py-0.5 rounded-full text-xs font-bold
                        @if($payment->status === 'completed') bg-green-100 text-green-800
                        @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800 @endif">
                            <i class="fas
                            @if($payment->status === 'completed') fa-check-circle
                            @elseif($payment->status === 'pending') fa-clock
                            @else fa-times-circle @endif mr-1"></i>
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>
                    <div class="info-item mb-1">
                        <span class="info-label font-bold text-gray-600">Payment Method:</span>
                        <i class="fas
                        @if($payment->payment_method === 'cash') fa-money-bill-wave
                        @elseif($payment->payment_method === 'card') fa-credit-card
                        @else fa-globe @endif mr-1"></i>
                        {{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}
                    </div>
                </div>
            </div>

            <!-- Company Address -->
            <div class="text-center mb-3 text-xs text-gray-600">
                <p>Zila School Road, Near Mi Care, (Purnia), Bihar - 854301</p>
                <p>7856802002 | novafixteam@gmail.com</p>
            </div>

            <!-- Device and Service Details -->
            <table class="details-table w-full border-collapse mb-3 text-xs">
                <tr>
                    <td class="label font-bold bg-gray-50 border border-gray-300 p-1 w-1/4">Device Name</td>
                    <td class="border border-gray-300 p-1">{{ strtoupper($serviceRequest->product_name) }}</td>
                    <td class="label font-bold bg-gray-50 border border-gray-300 p-1 w-1/4">Service Code</td>
                    <td class="border border-gray-300 p-1">{{ $serviceRequest->service_code }}</td>
                </tr>
                <tr>
                    <td class="label font-bold bg-gray-50 border border-gray-300 p-1">Problem Reported</td>
                    <td class="border border-gray-300 p-1">{{ strtoupper($serviceRequest->problem) }}</td>
                    <td class="label font-bold bg-gray-50 border border-gray-300 p-1">Brand</td>
                    <td class="border border-gray-300 p-1">{{ strtoupper($serviceRequest->brand) }}</td>
                </tr>
                <tr>
                    <td class="label font-bold bg-gray-50 border border-gray-300 p-1">Service Category</td>
                    <td class="border border-gray-300 p-1">
                        {{ strtoupper($serviceRequest->serviceCategory->name ?? 'N/A') }}</td>
                    <td class="label font-bold bg-gray-50 border border-gray-300 p-1">Serial Number</td>
                    <td class="border border-gray-300 p-1">{{ $serviceRequest->serial_no ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label font-bold bg-gray-50 border border-gray-300 p-1">Color</td>
                    <td class="border border-gray-300 p-1">{{ strtoupper($serviceRequest->color) }}</td>
                    <td class="label font-bold bg-gray-50 border border-gray-300 p-1">Est. Delivery</td>
                    <td class="border border-gray-300 p-1">
                        {{ \Carbon\Carbon::parse($serviceRequest->estimate_delivery)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td class="label font-bold bg-gray-50 border border-gray-300 p-1">Transaction ID</td>
                    <td class="border border-gray-300 p-1">{{ $payment->transaction_id ?? 'N/A' }}</td>
                    <td class="label font-bold bg-gray-50 border border-gray-300 p-1">Payment Date</td>
                    <td class="border border-gray-300 p-1">{{ $payment->created_at->format('d M Y, h:i A') }}</td>
                </tr>
                @if($serviceRequest->remark)
                    <tr>
                        <td class="label font-bold bg-gray-50 border border-gray-300 p-1">Remark</td>
                        <td class="border border-gray-300 p-1" colspan="3">{{ $serviceRequest->remark }}</td>
                    </tr>
                @endif
            </table>

            <!-- Payment Summary -->
            <div class="payment-summary bg-blue-50 rounded p-3 mb-3">
                <h3 class="text-center font-bold mb-2 text-sm">PAYMENT SUMMARY</h3>
                <div class="payment-row flex justify-between py-0.5 text-xs">
                    <span>Service Amount:</span>
                    <span>₹{{ number_format($payment->amount, 2) }}</span>
                </div>
                <div class="payment-row flex justify-between py-0.5 text-xs">
                    <span>Discount:</span>
                    <span>- ₹{{ number_format($payment->discount, 2) }}</span>
                </div>
                <div class="payment-row flex justify-between py-0.5 text-xs">
                    <span>Tax
                        ({{ $payment->tax > 0 ? round(($payment->tax / $payment->amount) * 100, 2) : 0 }}%):</span>
                    <span>+ ₹{{ number_format($payment->tax, 2) }}</span>
                </div>
                <div class="payment-row flex justify-between border-t border-gray-300 pt-1 mt-1 font-bold text-sm">
                    <span>TOTAL AMOUNT:</span>
                    <span>₹{{ number_format($payment->total_amount, 2) }}</span>
                </div>
                @if($payment->notes)
                    <div class="mt-2 pt-1 border-t border-dashed border-gray-300 text-xs">
                        <p><strong>Notes:</strong> {{ $payment->notes }}</p>
                    </div>
                @endif
            </div>

            <!-- Thank You Message -->
            <p class="text-center italic mb-3 text-xs">Thank you for choosing NovaFix!</p>

            <!-- Terms and Conditions -->
            <div class="terms bg-gray-50 rounded p-2 text-[9px]">
                <strong>Terms & Conditions:</strong>
                <ol class="pl-3 mt-1 list-decimal">
                    <li>Product not collected within 30 days not our responsibility.</li>
                    <li>Confirm by phone before collecting product.</li>
                    <li>Warranty only for GST-included repairs.</li>
                    <li>₹350 checking fee if not repaired/declined.</li>
                </ol>
            </div>

            <!-- Signature Area -->
            <div class="signature-area text-right mt-3 pt-2 border-t border-dashed border-gray-300 text-xs">
                <p>Authorized Sign & Stamp</p>
            </div>

            <!-- Footer -->
            <div class="footer text-center text-[9px] text-gray-500 mt-3">
                <p>Generated on: {{ now()->format('d M Y, h:i A') }}</p>
                <p>Computer-generated receipt. No signature required.</p>
            </div>

            <!-- Print Button -->
            <div class="no-print text-center mt-4">
                <button onclick="window.print()"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-4 rounded flex items-center justify-center mx-auto text-sm">
                    <i class="fas fa-print mr-1"></i> Print
                </button>
            </div>
        </div>
    </div>
   
</div>