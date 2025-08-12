<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-blue-600 mb-2">NovaFix</h1>
        <h2 class="text-2xl font-bold text-gray-800">Set New Password</h2>
        <p class="text-gray-600 mt-2">Please create a new password for your account</p>
    </div>
    
    <form wire:submit.prevent="resetPassword">
        <input type="hidden" wire:model="token">
        
        <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
            <p class="text-sm text-gray-500 mb-1">Account Email</p>
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                </svg>
                <span class="font-medium text-gray-700">{{ $email }}</span>
            </div>
        </div>
        
        <div class="mb-4">
            <label for="password" class="block text-gray-700 mb-2">New Password</label>
            <input id="password" type="password" wire:model="password" 
                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="Enter your new password"
                   required>
            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            <p class="text-xs text-gray-500 mt-1">Must be at least 8 characters</p>
        </div>
        
        <div class="mb-6">
            <label for="password_confirmation" class="block text-gray-700 mb-2">Confirm Password</label>
            <input id="password_confirmation" type="password" wire:model="password_confirmation" 
                   class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="Re-enter your new password"
                   required>
        </div>
        
        <button type="submit" 
                class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-200">
            Reset Password
        </button>
        
        <div class="mt-6 text-center text-sm text-gray-500">
            <p>Having trouble? Contact NovaFix support at <a href="mailto:support@novafix.com" class="text-blue-600 hover:underline">support@novafix.com</a></p>
        </div>
    </form>
</div>