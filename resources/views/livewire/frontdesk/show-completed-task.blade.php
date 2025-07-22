<div>
    <div class="bg-white rounded-lg shadow-xl max-w-4xl mx-auto p-6">
        <div class="flex justify-between items-start mb-6">
            <h3 class="text-xl font-bold">Service Request Details</h3>
            <button wire:click="$dispatch('closeModal')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Customer Details -->
            <div class="space-y-4">
                <h4 class="font-medium text-lg border-b pb-2">Customer Information</h4>
                <div>
                    <p class="text-sm text-gray-500">Name</p>
                    <p class="font-medium">{{ $request->owner_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Contact</p>
                    <p class="font-medium">{{ $request->contact }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-medium">{{ $request->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Address</p>
                    <p class="font-medium">{{ $request->address }}</p>
                </div>
            </div>

            <!-- Product Details -->
            <div class="space-y-4">
                <h4 class="font-medium text-lg border-b pb-2">Product Information</h4>
                <div>
                    <p class="text-sm text-gray-500">Product Name</p>
                    <p class="font-medium">{{ $request->product_name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Brand/Model</p>
                    <p class="font-medium">{{ $request->brand }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Serial Number</p>
                    <p class="font-medium">{{ $request->serial_no }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Issue Description</p>
                    <p class="font-medium">{{ $request->issue_description }}</p>
                </div>
            </div>
        </div>

        <!-- Service Details -->
        <div class="mt-6 space-y-4">
            <h4 class="font-medium text-lg border-b pb-2">Service Information</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Service Code</p>
                    <p class="font-medium">{{ $request->service_code }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="font-medium">
                        <span class="px-2 py-1 rounded-full bg-green-100 text-green-800 text-xs">
                            Completed
                        </span>
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Completed On</p>
                    <p class="font-medium">{{ $request->updated_at->format('M d, Y h:i A') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Receptionist</p>
                    <p class="font-medium">{{ $request->receptionist->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Technician</p>
                    <p class="font-medium">{{ $request->technician->name ?? 'Not assigned' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Completion Notes</p>
                    <p class="font-medium">{{ $request->completion_notes ?? 'No notes provided' }}</p>
                </div>
            </div>
        </div>

        <!-- Payment Section -->
        <div class="mt-6 space-y-4">
            <h4 class="font-medium text-lg border-b pb-2">Payment Information</h4>

            @if ($request->payments->count() > 0)
                <div class="mb-4 bg-blue-50 p-3 rounded-lg">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium text-gray-700">Payment Status:</p>
                            <p class="text-lg font-semibold">
                                <span
                                    class="px-2 py-1 rounded-full 
                                    {{ $request->payments->last()->status === 'completed'
                                        ? 'bg-green-100 text-green-800'
                                        : ($request->payments->last()->status === 'pending'
                                            ? 'bg-yellow-100 text-yellow-800'
                                            : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($request->payments->last()->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-700">Total Amount:</p>
                            <p class="text-lg font-bold text-blue-600">
                                {{ number_format($request->payments->last()->total_amount, 2) }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-2 text-sm text-gray-500">
                        Last updated: {{ $request->payments->last()->updated_at->format('M d, Y h:i A') }}
                    </div>
                </div>
            @endif

            <!-- Payment Form - Only show if no completed payment exists -->
            @if ($showPaymentForm)
                <div class="mt-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h5 class="font-medium mb-4">
                        @if ($editingPaymentId)
                            Update Payment Details
                        @else
                            Record New Payment
                        @endif
                    </h5>

                    <form wire:submit.prevent="savePayment">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Amount -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Amount*</label>
                                <input type="number" wire:model="amount" step="0.01"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('amount')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Discount -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Discount</label>
                                <input type="number" wire:model="discount" step="0.01"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('discount')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tax -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tax</label>
                                <input type="number" wire:model="tax" step="0.01"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('tax')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Total (readonly) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Total</label>
                                <input type="number" wire:model="total_amount" readonly
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-100 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <!-- Payment Method -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Payment Method*</label>
                                <select wire:model="payment_method"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="transfer">Bank Transfer</option>
                                </select>
                                @error('payment_method')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>


                            <!-- Status -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status*</label>
                                <select wire:model="status"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="completed" selected>Completed</option>
                                    <option value="pending">Pending</option>
                                    <option value="failed">Failed</option>
                                </select>
                                @error('status')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Notes</label>
                                <textarea wire:model="notes" rows="3"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                                @error('notes')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            @if ($editingPaymentId)
                                <button type="button" wire:click="resetPaymentForm"
                                    class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                                    Cancel
                                </button>
                            @endif
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                <i class="fas fa-save mr-2"></i>
                                @if ($editingPaymentId)
                                    Update Payment
                                @else
                                    Save Payment
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
        <!-- Delivery Status -->
        <div class="mt-6 space-y-4">
            <h4 class="font-medium text-lg border-b pb-2">Delivery Status</h4>
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                @if ($request->delivery_status == '1')
                    <span class="text-green-600 font-semibold">
                        <i class="fas fa-check-circle mr-2"></i> Delivered
                    </span>
                @else
                    <span class="text-yellow-600 font-semibold">
                        <i class="fas fa-exclamation-triangle mr-2"></i> Not Delivered
                    </span>
                @endif
                @if ($request->delivery_status !== '1' && $request->payments->where('status', 'completed')->count() > 0)
                    <button wire:click="markAsDelivered"
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        <i class="fas fa-truck mr-2"></i> Mark as Delivered
                    </button>
                @endif
            </div>
        </div>
        <!-- Flash Message -->
        @if (session()->has('payment-success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg">
                <i class="fas fa-check-circle mr-2"></i> {{ session('payment-success') }}
            </div>
        @endif
        <!-- Flash Message for Delivery -->
        @if (session()->has('delivery-success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg">
                <i class="fas fa-check-circle mr-2"></i> {{ session('delivery-success') }}
            </div>
        @endif
    </div>
</div>
