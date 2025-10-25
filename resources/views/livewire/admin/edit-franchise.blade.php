<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto max-w-4xl px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit Franchise</h1>
            <p class="text-gray-600">Update franchise information and details</p>
        </div>
        
        <!-- Success/Error Messages -->
        @if (session()->has('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        
        @if (session()->has('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <!-- Form Section -->
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <form wire:submit.prevent="submit" class="p-8">
                <!-- Basic Information Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 pb-2 border-b border-gray-100">Basic Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Franchise Name -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="franchise_name">
                                Franchise Name <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="franchise_name" 
                                   class="w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" 
                                   id="franchise_name" 
                                   type="text" 
                                   placeholder="Enter franchise name">
                            @error('franchise_name') 
                                <span class="text-red-500 text-xs mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>

                        <!-- Contact Number -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="contact_no">
                                Contact Number <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="contact_no" 
                                   class="w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" 
                                   id="contact_no" 
                                   type="text" 
                                   placeholder="Enter contact number">
                            @error('contact_no') 
                                <span class="text-red-500 text-xs mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mt-6">
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="email">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input wire:model="email" 
                               class="w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" 
                               id="email" 
                               type="email" 
                               placeholder="Enter email address">
                        @error('email') 
                            <span class="text-red-500 text-xs mt-1 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </span> 
                        @enderror
                    </div>

                    <!-- Change Password Button -->
                    <div class="mt-6">
                        <button type="button" 
                                wire:click="$set('showPasswordModal', true)"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                            Change Password
                        </button>
                    </div>
                </div>

                <!-- Legal Documents Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 pb-2 border-b border-gray-100">Legal Documents</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Aadhar Number -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="aadhar_no">
                                Aadhar Number
                            </label>
                            <input wire:model="aadhar_no" 
                                   class="w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" 
                                   id="aadhar_no" 
                                   type="text" 
                                   placeholder="Enter Aadhar number">
                            @error('aadhar_no') 
                                <span class="text-red-500 text-xs mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>

                        <!-- PAN Number -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="pan_no">
                                PAN Number
                            </label>
                            <input wire:model="pan_no" 
                                   class="w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" 
                                   id="pan_no" 
                                   type="text" 
                                   placeholder="Enter PAN number">
                            @error('pan_no') 
                                <span class="text-red-500 text-xs mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Bank Details Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 pb-2 border-b border-gray-100">Bank Details</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="bank_name">
                                Bank Name
                            </label>
                            <input wire:model="bank_name" 
                                   class="w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" 
                                   id="bank_name" 
                                   type="text" 
                                   placeholder="Bank name">
                            @error('bank_name') 
                                <span class="text-red-500 text-xs mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="account_no">
                                Account Number
                            </label>
                            <input wire:model="account_no" 
                                   class="w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" 
                                   id="account_no" 
                                   type="text" 
                                   placeholder="Account number">
                            @error('account_no') 
                                <span class="text-red-500 text-xs mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="ifsc_code">
                                IFSC Code
                            </label>
                            <input wire:model="ifsc_code" 
                                   class="w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" 
                                   id="ifsc_code" 
                                   type="text" 
                                   placeholder="IFSC code">
                            @error('ifsc_code') 
                                <span class="text-red-500 text-xs mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Address Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 pb-2 border-b border-gray-100">Address Information</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="street">
                                Street
                            </label>
                            <input wire:model="street" 
                                   class="w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" 
                                   id="street" 
                                   type="text" 
                                   placeholder="Street address">
                            @error('street') 
                                <span class="text-red-500 text-xs mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="city">
                                City
                            </label>
                            <input wire:model="city" 
                                   class="w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" 
                                   id="city" 
                                   type="text" 
                                   placeholder="City">
                            @error('city') 
                                <span class="text-red-500 text-xs mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="district">
                                District
                            </label>
                            <input wire:model="district" 
                                   class="w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" 
                                   id="district" 
                                   type="text" 
                                   placeholder="District">
                            @error('district') 
                                <span class="text-red-500 text-xs mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="state">
                                State
                            </label>
                            <input wire:model="state" 
                                   class="w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" 
                                   id="state" 
                                   type="text" 
                                   placeholder="State">
                            @error('state') 
                                <span class="text-red-500 text-xs mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="country">
                                Country
                            </label>
                            <input wire:model="country" 
                                   class="w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" 
                                   id="country" 
                                   type="text" 
                                   placeholder="Country">
                            @error('country') 
                                <span class="text-red-500 text-xs mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="pincode">
                                Pincode
                            </label>
                            <input wire:model="pincode" 
                                   class="w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" 
                                   id="pincode" 
                                   type="text" 
                                   placeholder="Pincode">
                            @error('pincode') 
                                <span class="text-red-500 text-xs mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="doc">
                                Date of Commencement
                            </label>
                            <input wire:model="doc" 
                                   class="w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" 
                                   id="doc" 
                                   type="date">
                            @error('doc') 
                                <span class="text-red-500 text-xs mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Status Section -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 pb-2 border-b border-gray-100">Franchise Status</h2>
                    
                    <div class="max-w-xs">
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="status">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="status" 
                                class="w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" 
                                id="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="pending">Pending</option>
                        </select>
                        @error('status') 
                            <span class="text-red-500 text-xs mt-1 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </span> 
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end pt-6 border-t border-gray-100">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors flex items-center" type="submit">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update Franchise
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Password Change Modal -->
    @if($showPasswordModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
            <div class="bg-white rounded-xl max-w-md w-full p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Change Password</h3>
                    <button wire:click="$set('showPasswordModal', false)" 
                            class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="updatePassword">
                    <div class="space-y-4">
                        <!-- Current Password -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="current_password">
                                Current Password <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="current_password" 
                                   class="w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" 
                                   id="current_password" 
                                   type="password" 
                                   placeholder="Enter current password">
                            @error('current_password') 
                                <span class="text-red-500 text-xs mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="new_password">
                                New Password <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="new_password" 
                                   class="w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" 
                                   id="new_password" 
                                   type="password" 
                                   placeholder="Enter new password">
                            @error('new_password') 
                                <span class="text-red-500 text-xs mt-1 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>

                        <!-- Confirm New Password -->
                        <div>
                            <label class="block text-gray-700 text-sm font-medium mb-2" for="new_password_confirmation">
                                Confirm New Password <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="new_password_confirmation" 
                                   class="w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-700 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors" 
                                   id="new_password_confirmation" 
                                   type="password" 
                                   placeholder="Confirm new password">
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                        <button type="button" 
                                wire:click="$set('showPasswordModal', false)"
                                class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>