<div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 mt-14 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Create New Franchise</h2>

            <!-- Success Message -->
            @if (session()->has('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Message -->
            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @error('general')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ $message }}
                </div>
            @enderror

            <form wire:submit.prevent="submit">
                <!-- Basic Information -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Basic Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Franchise Name -->
                        <div>
                            <label for="franchise_name" class="block text-sm font-medium text-gray-700">Franchise
                                Name*</label>
                            <input wire:model="franchise_name" type="text" id="franchise_name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                            @error('franchise_name')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Contact Number -->
                        <div>
                            <label for="contact_no" class="block text-sm font-medium text-gray-700">Contact
                                Number*</label>
                            <input wire:model="contact_no" type="text" id="contact_no"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                            @error('contact_no')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email*</label>
                            <input wire:model="email" type="email" id="email"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                            @error('email')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password*</label>
                            <input wire:model="password" type="password" id="password"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                            @error('password')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                                Password*</label>
                            <input wire:model="password_confirmation" type="password" id="password_confirmation"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status*</label>
                            <select wire:model="status" id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                                <option value="pending">Pending</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            @error('status')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Financial Information -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Financial Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Aadhar Number -->
                        <div>
                            <label for="aadhar_no" class="block text-sm font-medium text-gray-700">Aadhar Number</label>
                            <input wire:model="aadhar_no" type="text" id="aadhar_no"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                            @error('aadhar_no')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- PAN Number -->
                        <div>
                            <label for="pan_no" class="block text-sm font-medium text-gray-700">PAN Number</label>
                            <input wire:model="pan_no" type="text" id="pan_no"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                            @error('pan_no')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Bank Name -->
                        <div>
                            <label for="bank_name" class="block text-sm font-medium text-gray-700">Bank Name</label>
                            <input wire:model="bank_name" type="text" id="bank_name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                            @error('bank_name')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Account Number -->
                        <div>
                            <label for="account_no" class="block text-sm font-medium text-gray-700">Account
                                Number</label>
                            <input wire:model="account_no" type="text" id="account_no"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                            @error('account_no')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- IFSC Code -->
                        <div>
                            <label for="ifsc_code" class="block text-sm font-medium text-gray-700">IFSC Code</label>
                            <input wire:model="ifsc_code" type="text" id="ifsc_code"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                            @error('ifsc_code')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Address Information -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Address Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Street -->
                        <div>
                            <label for="street" class="block text-sm font-medium text-gray-700">Street</label>
                            <input wire:model="street" type="text" id="street"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                            @error('street')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- City -->
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                            <input wire:model="city" type="text" id="city"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                            @error('city')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- District -->
                        <div>
                            <label for="district" class="block text-sm font-medium text-gray-700">District</label>
                            <input wire:model="district" type="text" id="district"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                            @error('district')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- State -->
                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700">State</label>
                            <input wire:model="state" type="text" id="state"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                            @error('state')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Country -->
                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                            <input wire:model="country" type="text" id="country"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                            @error('country')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Pincode -->
                        <div>
                            <label for="pincode" class="block text-sm font-medium text-gray-700">Pincode</label>
                            <input wire:model="pincode" type="text" id="pincode"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                            @error('pincode')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 border-b pb-2">Additional Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Date of Creation -->
                        <div>
                            <label for="doc" class="block text-sm font-medium text-gray-700">Date of
                                Creation</label>
                            <input wire:model="doc" type="date" id="doc"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border py-2 px-3 focus:ring-blue-500 focus:border-blue-500">
                            @error('doc')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                        Create Franchise
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
