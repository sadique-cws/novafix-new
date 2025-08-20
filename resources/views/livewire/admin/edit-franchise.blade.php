<div>
    <div class="container mx-auto ">
        <h1 class="text-2xl  mb-6">Edit Franchise</h1>
        
        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit.prevent="submit" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <!-- Franchise Name -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm  mb-2" for="franchise_name">
                    Franchise Name <span class="text-red-500">*</span>
                </label>
                <input wire:model="franchise_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="franchise_name" type="text" placeholder="Franchise Name">
                @error('franchise_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Contact Number -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm  mb-2" for="contact_no">
                    Contact Number <span class="text-red-500">*</span>
                </label>
                <input wire:model="contact_no" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="contact_no" type="text" placeholder="Contact Number">
                @error('contact_no') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm  mb-2" for="email">
                    Email <span class="text-red-500">*</span>
                </label>
                <input wire:model="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" placeholder="Email">
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Password (optional for update) -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm  mb-2" for="password">
                    New Password
                </label>
                <input wire:model="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="Leave blank to keep current password">
                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Password Confirmation -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm  mb-2" for="password_confirmation">
                    Confirm New Password
                </label>
                <input wire:model="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password_confirmation" type="password" placeholder="Confirm New Password">
            </div>

            <!-- Aadhar Number -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm  mb-2" for="aadhar_no">
                    Aadhar Number
                </label>
                <input wire:model="aadhar_no" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="aadhar_no" type="text" placeholder="Aadhar Number">
                @error('aadhar_no') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- PAN Number -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm  mb-2" for="pan_no">
                    PAN Number
                </label>
                <input wire:model="pan_no" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="pan_no" type="text" placeholder="PAN Number">
                @error('pan_no') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Bank Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm  mb-2" for="bank_name">
                        Bank Name
                    </label>
                    <input wire:model="bank_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="bank_name" type="text" placeholder="Bank Name">
                    @error('bank_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm  mb-2" for="account_no">
                        Account Number
                    </label>
                    <input wire:model="account_no" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="account_no" type="text" placeholder="Account Number">
                    @error('account_no') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm  mb-2" for="ifsc_code">
                        IFSC Code
                    </label>
                    <input wire:model="ifsc_code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="ifsc_code" type="text" placeholder="IFSC Code">
                    @error('ifsc_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Address -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm  mb-2" for="street">
                        Street
                    </label>
                    <input wire:model="street" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="street" type="text" placeholder="Street">
                    @error('street') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm  mb-2" for="city">
                        City
                    </label>
                    <input wire:model="city" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="city" type="text" placeholder="City">
                    @error('city') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm  mb-2" for="district">
                        District
                    </label>
                    <input wire:model="district" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="district" type="text" placeholder="District">
                    @error('district') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm  mb-2" for="state">
                        State
                    </label>
                    <input wire:model="state" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="state" type="text" placeholder="State">
                    @error('state') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm  mb-2" for="country">
                        Country
                    </label>
                    <input wire:model="country" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="country" type="text" placeholder="Country">
                    @error('country') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm  mb-2" for="pincode">
                        Pincode
                    </label>
                    <input wire:model="pincode" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="pincode" type="text" placeholder="Pincode">
                    @error('pincode') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm  mb-2" for="doc">
                        Date of Commencement
                    </label>
                    <input wire:model="doc" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="doc" type="date">
                    @error('doc') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Status -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm  mb-2" for="status">
                    Status <span class="text-red-500">*</span>
                </label>
                <select wire:model="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="status">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="pending">Pending</option>
                </select>
                @error('status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white  py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Update Franchise
                </button>
            </div>
        </form>
    </div>
</div>