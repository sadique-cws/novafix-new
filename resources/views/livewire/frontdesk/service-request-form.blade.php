<main class="flex-1 p-4 md:p-6 bg-gray-100 min-h-screen font-poppins">
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-2xl p-6">
        <h2 class="text-3xl font-semibold text-slate-700 mb-6">New Service Request</h2>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit.prevent="save" class="space-y-6" enctype="multipart/form-data">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Service Category Dropdown -->
                <div>
                    <label for="service_categories_id" class="block text-sm font-medium text-slate-600">Service
                        Category</label>
                    <select id="service_categories_id" wire:model="service_categories_id"
                        class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                        <option value="">Select Service Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('service_categories_id')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Technician Dropdown -->
                <div>
                    <label for="technician_id" class="block text-sm font-medium text-slate-600">Technician</label>
                    <select id="technician_id" wire:model="technician_id"
                        class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                        <option value="">Select Technician</option>
                        @foreach ($technicians as $tech)
                            <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                        @endforeach
                    </select>
                    @error('technician_id')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Basic Information -->
                <div>
                    <label for="service_code" class="block text-sm font-medium text-slate-600">Service Code</label>
                    <div class="mt-1 w-full rounded-md border border-slate-300 shadow-sm bg-gray-50 p-2">
                        {{ $service_code }}
                    </div>
                    <input type="hidden" wire:model="service_code">
                </div>

                <div>
                    <label for="owner_name" class="block text-sm font-medium text-slate-600">Owner Name</label>
                    <input type="text" id="owner_name" wire:model="owner_name" required
                        class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                    @error('owner_name')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="product_name" class="block text-sm font-medium text-slate-600">Product Name</label>
                    <input type="text" id="product_name" wire:model="product_name" required
                        class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                    @error('product_name')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-600">Email</label>
                    <input type="email" id="email" wire:model="email"
                        class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                    @error('email')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="contact" class="block text-sm font-medium text-slate-600">Contact</label>
                    <input type="text" id="contact" wire:model="contact" required
                        class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                    @error('contact')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="brand" class="block text-sm font-medium text-slate-600">Brand</label>
                    <input type="text" id="brand" wire:model="brand" required
                        class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                    @error('brand')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="serial_no" class="block text-sm font-medium text-slate-600">Serial No</label>
                    <input type="text" id="serial_no" wire:model="serial_no"
                        class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                    @error('serial_no')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="MAC" class="block text-sm font-medium text-slate-600">MAC Address</label>
                    <input type="text" id="MAC" wire:model="MAC"
                        class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                    @error('MAC')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="color" class="block text-sm font-medium text-slate-600">Color</label>
                    <input type="text" id="color" wire:model="color" required
                        class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                    @error('color')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="service_amount" class="block text-sm font-medium text-slate-600">Service Amount</label>
                    <input type="number" step="0.01" id="service_amount" wire:model="service_amount"
                        class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                    @error('service_amount')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Image Upload -->
                <div>
                    <label for="image" class="block text-sm font-medium text-slate-600">Product Image</label>
                    <input type="file" accept="image/*" capture="environment" wire:model="image" id="photo" 
                    class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                         
                    @error('image')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-slate-600">Status</label>
                    <input type="number" step="0.01" id="status" wire:model="status"
                        class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                    @error('status')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Problem and Remark -->
                <div class="md:col-span-2">
                    <label for="problem" class="block text-sm font-medium text-slate-600">Problem</label>
                    <textarea id="problem" wire:model="problem" rows="3" required
                        class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2"></textarea>
                    @error('problem')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="remark" class="block text-sm font-medium text-slate-600">Remark</label>
                    <textarea id="remark" wire:model="remark" rows="2"
                        class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2"></textarea>
                    @error('remark')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="estimate_delivery" class="block text-sm font-medium text-slate-600">Estimated
                        Delivery</label>
                    <input type="datetime-local" id="estimate_delivery" wire:model="estimate_delivery"
                        class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                    @error('estimate_delivery')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="date_of_delivery" class="block text-sm font-medium text-slate-600">Date of
                        Delivery</label>
                    <input type="datetime-local" id="date_of_delivery" wire:model="date_of_delivery"
                        class="mt-1 w-full rounded-md border border-slate-300 shadow-sm focus:ring-primary focus:border-primary p-2">
                    @error('date_of_delivery')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="w-full bg-indigo-600 text-white font-semibold py-2 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition duration-200">
                    Submit Request
                </button>
            </div>
        </form>
    </div>
</main>
