<div class="container mx-auto px-4 py-8">
    <!-- Printable Receipt Card -->
    <div class="bg-white rounded-lg shadow-md p-6 max-w-4xl mx-auto" id="receipt-content">
        <!-- Header with Logo and Receipt Info -->
        <div class="flex justify-between items-start border-b pb-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Service Request Receipt</h1>
                <div class="flex items-center space-x-4 mt-2">
                    <p class="text-gray-600">Request #: {{ $serviceRequest->id }}</p>
                    <p class="text-gray-600">Date: {{ $serviceRequest->created_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
            <!-- Status Badge -->
            <div class="px-4 py-1 rounded-full {{ $serviceRequest->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                {{ ucfirst($serviceRequest->status) }}
            </div>
        </div>

        <!-- Customer and Service Information -->
        <div class="grid md:grid-cols-2 gap-8 mb-8">
            <!-- Customer Details -->
            <div>
                <h2 class="text-lg font-semibold mb-4 pb-2 border-b text-gray-700">Customer Information</h2>
                <div class="space-y-3">
                    <p><span class="font-medium">Name:</span> {{ $serviceRequest->owner_name }}</p>
                    <p><span class="font-medium">Contact:</span> {{ $serviceRequest->contact }}</p>
                    <p><span class="font-medium">Email:</span> {{ $serviceRequest->email ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Service Details -->
            <div>
                <h2 class="text-lg font-semibold mb-4 pb-2 border-b text-gray-700">Service Details</h2>
                <div class="space-y-3">
                    <p><span class="font-medium">Service Code:</span> {{ $serviceRequest->service_code }}</p>
                    <p><span class="font-medium">Category:</span> {{ $serviceCategory->name ?? 'N/A' }}</p>
                    <p><span class="font-medium">Technician:</span> {{ $technician->name ?? 'Not assigned' }}</p>
                    <p><span class="font-medium">Priority:</span> {{ ucfirst($serviceRequest->priority) }}</p>
                </div>
            </div>
        </div>

        <!-- Product Information -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4 pb-2 border-b text-gray-700">Product Information</h2>
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <p><span class="font-medium">Product Name:</span> {{ $serviceRequest->product_name }}</p>
                    <p><span class="font-medium">Brand:</span> {{ $serviceRequest->brand }}</p>
                    <p><span class="font-medium">Color:</span> {{ $serviceRequest->color }}</p>
                </div>
                <div>
                    <p><span class="font-medium">Serial No:</span> {{ $serviceRequest->serial_no ?? 'N/A' }}</p>
                    <p><span class="font-medium">MAC Address:</span> {{ $serviceRequest->MAC ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Problem Description -->
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4 pb-2 border-b text-gray-700">Problem Description</h2>
            <div class="bg-gray-50 p-4 rounded border border-gray-200">
                {!! nl2br(e($serviceRequest->problem)) !!}
            </div>
        </div>

        <!-- Pricing and Delivery -->
        <div class="grid md:grid-cols-2 gap-8 mb-8">
            <!-- Pricing -->
            <div>
                <h2 class="text-lg font-semibold mb-4 pb-2 border-b text-gray-700">Pricing</h2>
                <div class="space-y-2">
                    <p><span class="font-medium">Service Amount:</span> 
                        @if($serviceRequest->service_amount)
                            ${{ number_format($serviceRequest->service_amount, 2) }}
                        @else
                            Not specified
                        @endif
                    </p>
                </div>
            </div>

            <!-- Delivery -->
            <div>
                <h2 class="text-lg font-semibold mb-4 pb-2 border-b text-gray-700">Delivery Information</h2>
                <div class="space-y-2">
                    <p><span class="font-medium">Estimated Delivery:</span> 
                        {{ $serviceRequest->estimate_delivery}}
                    </p>
                </div>
            </div>
        </div>

        <!-- Product Image -->
        @if($serviceRequest->image_path)
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4 pb-2 border-b text-gray-700">Product Image</h2>
            <div class="max-w-xs">
                <img src="{{ asset('storage/'.$serviceRequest->image_path) }}" alt="Product Image" class="rounded-md shadow-sm border border-gray-200">
            </div>
        </div>
        @endif

        <!-- Terms and Conditions -->
        <div class="mt-8 pt-6 border-t">
            <h2 class="text-lg font-semibold mb-2 text-gray-700">Terms & Conditions</h2>
            <ul class="list-disc pl-5 text-sm text-gray-600 space-y-1">
                <li>Warranty does not cover physical damage or liquid contact</li>
                <li>Repair time may vary based on parts availability</li>
                <li>Unclaimed items will be disposed after 30 days</li>
            </ul>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-wrap gap-4 mt-8 justify-center">
        <button onclick="printReceipt()" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd" />
            </svg>
            Print Receipt
        </button>

        <button wire:click="emailReceipt" 
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
            </svg>
            Email Receipt
        </button>
    </div>
</div>

@push('scripts')
<script>
    function printReceipt() {
        const printContent = document.getElementById('receipt-content').innerHTML;
        const originalContent = document.body.innerHTML;
        
        document.body.innerHTML = `
            <div class="p-6">${printContent}</div>
            <style>
                @media print {
                    body { 
                        font-size: 12pt; 
                        padding: 0; 
                        margin: 0; 
                    }
                    .flex, .grid { display: block; }
                    .hidden-print { display: none !important; }
                    .border-b { border-bottom: 1px solid #ddd; }
                    .border-t { border-top: 1px solid #ddd; }
                    .bg-white { background-color: white !important; }
                    .shadow-md { box-shadow: none !important; }
                    img { max-width: 200px !important; }
                }
            </style>
            <script>
                window.onload = function() {
                    window.print();
                    setTimeout(function() {
                        window.location.reload();
                    }, 500);
                };
            <\/script>
        `;
    }
</script>
@endpush