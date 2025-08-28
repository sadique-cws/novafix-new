
<div class="bg-gray-100 mt-6 flex items-center justify-center min-h-screen p-4 font-sans">
    <div class="w-full max-w-4xl bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-blue-600 text-white p-6 text-center">
            <h1 class="text-2xl font-bold">NovaFix Service Receipt</h1>
        </div>

        <!-- Customer Info -->
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ $serviceRequest->owner_name }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-600 text-sm">
                <div class="flex items-center">
                    <i class="fas fa-phone-alt mr-2 text-blue-600"></i>
                    <span>{{ $serviceRequest->contact }}</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-envelope mr-2 text-blue-600"></i>
                    <span>{{ $serviceRequest->email }}</span>
                </div>
            </div>
        </div>

        <!-- Service Details -->
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Service Request Details</h3>
                <div class="no-print">
                    <button wire:click="printReceipt" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                        Print Receipt
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-sm text-gray-700">
                    <tbody>
                        <tr class="bg-gray-50">
                            <td class="border border-gray-200 px-4 py-2 font-medium">Customer Name</td>
                            <td class="border border-gray-200 px-4 py-2" id="customer-name">{{ $serviceRequest->owner_name}}</td>
                            <td class="border border-gray-200 px-4 py-2 font-medium">Service Code</td>
                            <td class="border border-gray-200 px-4 py-2" id="service-code">{{ $serviceRequest->service_code }}</td>
                        </tr>
                           <tr class="bg-gray-50">
                            <td class="border border-gray-200 px-4 py-2 font-medium">Type</td>
                            <td class="border border-gray-200 px-4 py-2" id="type">{{ $serviceRequest->category->name }}</td>
                            <td class="border border-gray-200 px-4 py-2 font-medium">Serial Number</td>
                            <td class="border border-gray-200 px-4 py-2" id="serial-number">S24V</td>
                        </tr>
                         <tr>
                            <td class="border border-gray-200 px-4 py-2 font-medium">Color</td>
                            <td class="border border-gray-200 px-4 py-2" id="color">{{ $serviceRequest->color }}</td>
                            <td class="border border-gray-200 px-4 py-2 font-medium">Model</td>
                            <td class="border border-gray-200 px-4 py-2" id="model-number">{{ $serviceRequest->brand }}</td>
                        </tr>
                        <tr>
                            
                            <td class="border border-gray-200 px-4 py-2 font-medium">Estimated Delivery</td>
                            <td class="border border-gray-200 px-4 py-2" id="delivery-date">{{ $serviceRequest->estimate_delivery ?? 'N/A' }}</td>
                             <td class="border border-gray-200 px-4 py-2 font-medium">Status</td>
                            <td class="border border-gray-200 px-4 py-2">
                                {{ $serviceRequest->status == 0 ? 'Pending' : ($serviceRequest->status == 25 ? 'Processing' : ($serviceRequest->status == '90' ? 'Cancelled' : ($serviceRequest->status == 100 ? 'Completed' : 'Ready for Pickup'))) }}
                            </td>
                           
                        </tr>
                     
                       
                      
                        <tr>
                            <td class="border border-gray-200 px-4 py-2 font-medium">Remark</td>
                            <td class="border border-gray-200 px-4 py-2" id="remarks" colspan="3">{{ $serviceRequest->remark ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            
                            <td class="border border-gray-200 px-4 py-2 font-medium">Problem</td>
                            <td class="border border-gray-200 px-4 py-2" id="problem" colspan="3">{{ $serviceRequest->problam }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 p-6 text-center text-gray-600 text-sm">
            <h3 class="text-lg font-semibold text-gray-800 mb-2">NovaFix</h3>
            <p>Balaji Laptop & NovaFix</p>
            <p>Zila School Road, Near Nokia/MI Care, Purnia, Bihar - 854301</p>
            <div class="mt-3 flex flex-col sm:flex-row sm:justify-center gap-4">
                <div class="flex items-center justify-center">
                    <i class="fas fa-phone-alt mr-2 text-blue-600"></i>
                    <span>9304599132</span>
                </div>
                <div class="flex items-center justify-center">
                    <i class="fas fa-envelope mr-2 text-blue-600"></i>
                    <span>infotechbalaji108@gmail.com</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('printReceipt', () => {
                window.print();
            });
        });
    </script>
</div>