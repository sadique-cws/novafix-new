<div>
    <div class="receipt-container">
        <div class="receipt">
            <div class="header">
                <div class="receipt-number">Receipt No: {{ $receipt->service_code }}</div>
                <div class="company-name">NovaFix</div>
                <div class="tagline">Fixing Today, Securing Tomorrow!</div>
            </div>

            <div class="customer-info">
                <div><strong>Name:</strong> {{ $receipt->owner_name }}</div>
                <div><strong>Contact:</strong> {{ $receipt->contact }}</div>
                <div><strong>Email:</strong> {{ $receipt->email ?? 'N/A' }}</div>
            </div>

            <div class="address">
                Zila School Road, Near Mi care,<br>
                (Purnia), Bihar - 854301
            </div>

            <div class="contact">
                7856802002 | novafixteam@gmail.com
            </div>

            <table class="details-table">
                <tr>
                    <td class="field-name">Name</td>
                    <td>{{ strtoupper($receipt->owner_name) }}</td>
                    <td class="field-name">Service Code</td>
                    <td>{{ $receipt->service_code }}</td>
                </tr>
                <tr>
                    <td class="field-name">Problem</td>
                    <td>{{ strtoupper($receipt->problem) }}</td>
                    <td class="field-name">Brand</td>
                    <td>{{ strtoupper($receipt->brand) }}</td>
                </tr>
                <tr>
                    <td class="field-name">Type</td>
                    <td>{{ strtoupper($receipt->serviceCategory->name ?? 'N/A') }}</td>
                    <td class="field-name">S.N</td>
                    <td>JSJSKA</td> {{-- Hardcoded as not in schema --}}
                </tr>
                <tr>
                    <td class="field-name">MAC</td>
                    <td></td> {{-- Not in schema --}}
                    <td class="field-name">Color</td>
                    <td>{{ strtoupper($receipt->color) }}</td>
                </tr>
                <tr>
                    <td class="field-name">Model No</td>
                    <td>{{ $receipt->product_name }}</td>
                    <td class="field-name">Delivery Date</td>
                    <td>{{ $deliveryDate }}</td>
                </tr>
                <tr>
                    <td class="field-name">Estimated Delivery</td>
                    <td>{{ $receipt->estimate_delivery }}</td>
                    <td class="field-name">Status</td>
                    <td>{{ $statusText }}</td>
                </tr>
                <tr>
                    <td class="field-name">Remark</td>
                    <td>{{ $receipt->remark ?? 'N/A' }}</td>
                    <td></td>
                    <td></td>
                </tr>
            </table>

            <div class="thank-you">
                Thank you for choosing NovaFix. We appreciate your trust in our service!
            </div>

            <div class="terms">
                <strong>Terms & Conditions:</strong>
                <ol>
                    <li>We will not be responsible if the product is not taken back within 30 days.</li>
                    <li>Please confirm by phone before collecting your product.</li>
                    <li>Warranty applies only to GST-included repairs.</li>
                    <li>Rs. 350 checking fee applies if not repaired or repair declined.</li>
                </ol>
            </div>

            <div class="signature">
                Authorized Sign & Stamp
            </div>

            <div class="footer">
                <p>Generated on: {{ $generatedDate }}</p>
            </div>
        </div>

        <div class="no-print" style="text-align: center; margin-top: 20px;">
            <button wire:click="printReceipt" style="padding: 10px 20px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Print Receipt
            </button>
        </div>
    </div>

    <style>
        .receipt {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
        }
        .tagline {
            font-style: italic;
            margin-bottom: 10px;
        }
        .customer-info, .address, .contact {
            margin-bottom: 15px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .details-table td {
            padding: 5px;
            border: 1px solid #ddd;
        }
        .field-name {
            font-weight: bold;
            background-color: #f5f5f5;
        }
        .thank-you {
            text-align: center;
            margin: 20px 0;
            font-style: italic;
        }
        .terms {
            margin-bottom: 20px;
        }
        .signature {
            text-align: right;
            margin-top: 50px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
        @media print {
            .no-print {
                display: none;
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