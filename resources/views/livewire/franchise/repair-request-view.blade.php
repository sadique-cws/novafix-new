<div class="space-y-6">
    <x-slot name="navbar_back">
        <a wire:navigate href="{{ route('franchise.repair-requests') }}" class="text-gray-400 hover:text-white transition-colors">
            <i class="fas fa-arrow-left text-lg"></i>
        </a>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Request Details -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Request Information</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase mb-1">Owner Name</p>
                        <p class="text-lg font-medium text-gray-900">{{ $request->owner_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase mb-1">Contact</p>
                        <p class="text-lg font-medium text-gray-900">{{ $request->contact }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase mb-1">Email</p>
                        <p class="text-lg font-medium text-gray-900">{{ $request->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase mb-1">Problem</p>
                        <p class="text-lg font-medium text-gray-900">{{ $request->problem }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm font-bold text-gray-500 uppercase mb-1">Remark</p>
                        <p class="text-lg font-medium text-gray-900">{{ $request->remark ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Device & Status Details -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Device & Status</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase mb-1">Product</p>
                        <p class="text-lg font-medium text-gray-900">{{ $request->product_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase mb-1">Brand</p>
                        <p class="text-lg font-medium text-gray-900">{{ $request->brand }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase mb-1">Color</p>
                        <p class="text-lg font-medium text-gray-900">{{ $request->color }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Service Amount</p>
                        <p class="text-lg font-medium text-gray-900">₹{{ $request->payment->total_amount ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase mb-1">Status</p>
                        <div class="mt-1">
                            @if (in_array((string)$request->status, ['0', '1']))
                                <x-ui.badge color="yellow">Pending</x-ui.badge>
                            @elseif(in_array((string)$request->status, ['25', '50', '2']))
                                <x-ui.badge color="blue">In Progress</x-ui.badge>
                            @elseif(in_array((string)$request->status, ['100', '3']))
                                <x-ui.badge color="green">Completed</x-ui.badge>
                            @elseif((string)$request->status == '90')
                                <x-ui.badge color="red">Cancelled</x-ui.badge>
                            @else
                                <x-ui.badge color="gray">{{ $request->status ?? 'Unknown' }}</x-ui.badge>
                            @endif
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-500 uppercase mb-1">Delivery Status</p>
                        <div class="mt-1">
                            @if($request->delivery_status)
                                <x-ui.badge color="green">Delivered</x-ui.badge>
                            @else
                                <x-ui.badge color="yellow">Not Delivered</x-ui.badge>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <p class="text-sm font-bold text-gray-500 uppercase mb-2">Device Image</p>
                    @if ($request->image)
                        <img src="{{ $request->image }}" alt="Service Image" class="h-40 w-40 object-cover rounded-lg border border-gray-200">
                    @else
                        <div class="h-40 w-40 bg-gray-50 border border-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                            No Image
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Assign Receptioner -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-800">Assign Receptioner</h3>
        </div>
        <div class="p-6">
            <form wire:submit.prevent="updateReceptioner" class="flex flex-col sm:flex-row items-end gap-4 max-w-2xl">
                <div class="flex-grow w-full">
                    <label class="block text-sm font-bold text-gray-500 uppercase mb-2">Select Receptioner</label>
                    <x-ui.select wire:model="receptioner_id">
                        <option value="">-- Select Receptioner --</option>
                        @foreach($receptioners as $receptioner)
                            <option value="{{ $receptioner->id }}">
                                {{ $receptioner->name }}
                            </option>
                        @endforeach
                    </x-ui.select>
                </div>
                <div class="w-full sm:w-auto">
                    <x-ui.button type="submit" variant="primary" class="w-full">
                        Update
                    </x-ui.button>
                </div>
            </form>

            @if (session()->has('success'))
                <div class="mt-4 p-3 bg-green-50 text-green-700 rounded-lg text-sm border border-green-200">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
</div>
