<div>
    <div class="receipt-container">
    <div class="receipt">
        <div class="header">
            <h2 class="company-name">NovaFix</h2>
            <p class="tagline">Fixing Today, Securing Tomorrow!</p>
            <p class="receipt-number">Receipt Service Code: {{ $receipt->service_code }}</p>
        </div>

        <div class="customer-info">
            <p><strong>Name:</strong> {{ $receipt->owner_name }}</p>
            <p><strong>Contact:</strong> {{ $receipt->contact }}</p>
            <p><strong>Email:</strong> {{ $receipt->email ?? 'N/A' }}</p>
        </div>

        <p class="address">
            Zila School Road, Near Mi Care, (Purnia), Bihar - 854301
        </p>
        <p class="contact">7856802002 | novafixteam@gmail.com</p>

        <table class="details-table">
            <tr>
                <td><strong>Name</strong></td>
                <td>{{ strtoupper($receipt->owner_name) }}</td>
                <td><strong>Service Code</strong></td>
                <td>{{ $receipt->service_code }}</td>
            </tr>
            <tr>
                <td><strong>Problem</strong></td>
                <td>{{ strtoupper($receipt->problem) }}</td>
                <td><strong>Brand</strong></td>
                <td>{{ strtoupper($receipt->brand) }}</td>
            </tr>
            <tr>
                <td><strong>Type</strong></td>
                <td>{{ strtoupper($receipt->serviceCategory->name ?? 'N/A') }}</td>
                <td><strong>S.N</strong></td>
                <td>JSJSKA</td>
            </tr>
            <tr>
                <td><strong>MAC</strong></td>
                <td>N/A</td>
                <td><strong>Color</strong></td>
                <td>{{ strtoupper($receipt->color) }}</td>
            </tr>
            <tr>
                <td><strong>Model No</strong></td>
                <td>{{ $receipt->product_name }}</td>
                <td><strong>Delivery Date</strong></td>
                <td>{{ $deliveryDate }}</td>
            </tr>
            <tr>
                <td><strong>Estimated Delivery</strong></td>
                <td>{{ \Carbon\Carbon::parse($receipt->estimate_delivery)->format('d-m-Y') }}</td>
                <td><strong>Status</strong></td>
                <td>{{ $statusText }}</td>
            </tr>
            <tr>
                <td><strong>Remark</strong></td>
                <td colspan="3">{{ $receipt->remark ?? 'N/A' }}</td>
            </tr>
        </table>

        <p class="thank-you">
            Thank you for choosing NovaFix. We appreciate your trust in our service!
        </p>

        <div class="terms">
            <strong>Terms & Conditions:</strong>
            <ol>
                <li>We will not be responsible if the product is not taken back within 30 days.</li>
                <li>Please confirm by phone before collecting your product.</li>
                <li>Warranty applies only to GST-included repairs.</li>
                <li>Rs. 350 checking fee applies if not repaired or repair declined.</li>
            </ol>
        </div>

        <p class="signature">Authorized Sign & Stamp</p>

        <div class="footer">
            <p>Generated on: {{ $generatedDate }}</p>
        </div>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 15px;">
        <button wire:click="printReceipt" class="print-btn">
            Print Receipt
        </button>
    </div>
</div>

<style>
    .receipt {
        font-family: Arial, sans-serif;
        max-width: 600px;
        margin: auto;
        padding: 20px;
        border: 1px solid #ddd;
        font-size: 14px;
    }
    .header { text-align: center; margin-bottom: 15px; }
    .company-name { font-size: 20px; font-weight: bold; }
    .tagline { font-style: italic; font-size: 12px; color: #555; }
    .receipt-number { margin-top: 5px; font-size: 13px; }
    .customer-info p, .address, .contact { margin: 3px 0; }
    .details-table { width: 100%; border-collapse: collapse; margin: 15px 0; }
    .details-table td { border: 1px solid #ccc; padding: 6px; }
    .thank-you { text-align: center; font-style: italic; margin: 15px 0; }
    .terms { font-size: 12px; margin-top: 10px; }
    .signature { text-align: right; margin-top: 30px; }
    .footer { text-align: center; font-size: 11px; margin-top: 10px; color: #666; }
    .print-btn { padding: 8px 16px; background: #4CAF50; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
    .print-btn:hover { background: #45a049; }
    @media print { .no-print { display: none; } }
</style>

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('printReceipt', () => {
            window.print();
        });
    });
</script>

</div>