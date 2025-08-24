<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaFix Service Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .receipt {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border: 1px solid #ccc;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .company-name {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .tagline {
            font-size: 16px;
            font-style: italic;
            margin-bottom: 15px;
        }
        .receipt-number {
            font-size: 18px;
            font-weight: bold;
        }
        .customer-info {
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .address {
            text-align: center;
            margin: 15px 0;
            font-size: 14px;
            line-height: 1.4;
        }
        .contact {
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .details-table td {
            padding: 8px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        .details-table .field-name {
            font-weight: bold;
            background-color: #f9f9f9;
            width: 25%;
        }
        .thank-you {
            text-align: center;
            margin: 20px 0;
            font-style: italic;
        }
        .terms {
            margin-top: 25px;
            font-size: 14px;
        }
        .terms ol {
            padding-left: 20px;
            margin: 10px 0;
        }
        .terms li {
            margin-bottom: 5px;
        }
        .signature {
            margin-top: 40px;
            text-align: right;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .receipt {
                box-shadow: none;
                border: none;
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <div class="receipt-number">Receipt No: SX-103-4</div>
            <div class="company-name">NovaFix</div>
            <div class="tagline">Fixing Today, Securing Tomorrow!</div>
        </div>

        <div class="customer-info">
            <div><strong>Name:</strong> Imran</div>
            <div><strong>Contact:</strong> 6299390700</div>
            <div><strong>Email:</strong> imran@gmail.com</div>
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
                <td>IMRAN</td>
                <td class="field-name">Service Code</td>
                <td>ZALQ4W</td>
            </tr>
            <tr>
                <td class="field-name">Problem</td>
                <td>DEAD</td>
                <td class="field-name">Brand</td>
                <td>SAMSUNG</td>
            </tr>
            <tr>
                <td class="field-name">Type</td>
                <td>MOBILE/TABLET</td>
                <td class="field-name">S.N</td>
                <td>JSJSKA</td>
            </tr>
            <tr>
                <td class="field-name">MAC</td>
                <td></td>
                <td class="field-name">Color</td>
                <td>WHITE</td>
            </tr>
            <tr>
                <td class="field-name">Model No</td>
                <td>S22</td>
                <td class="field-name">Delivery Date</td>
                <td>14 Jun 2025</td>
            </tr>
            <tr>
                <td class="field-name">Estimated Delivery</td>
                <td>24 Jun 2025</td>
                <td class="field-name">Status</td>
                <td>pending</td>
            </tr>
            <tr>
                <td class="field-name">Remark</td>
                <td>N/A</td>
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
            <p>Generated on: 23 August 2025</p>
        </div>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Print Receipt
        </button>
    </div>
</body>
</html>  