<div class="max-w-md mx-auto   m-4  relative min-h-[500px] flex flex-col justify-center">
   <div class="rounded-lg border m-4 shadow-md p-8 ">
     <!-- Loading Overlay -->
    <div wire:loading.flex class="absolute inset-0 bg-white bg-opacity-70 items-center justify-center z-10 rounded-lg">
        <div class="text-center">
            <svg class="animate-spin h-8 w-8 text-blue-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="mt-2 text-gray-600">Processing your request...</p>
        </div>
    </div>

    @if(!$emailSent)
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Reset Password</h2>
        
        <div class="mb-4 text-sm text-gray-600">
            Forgot your password? Enter your email address and we'll send you a link to reset it.
        </div>

        @if($error)
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                {{ $error }}
            </div>
        @endif

        <form wire:submit.prevent="sendResetLink">
            <div class="mb-4">
                <label for="email" class="block text-gray-700 mb-2">Email Address</label>
                <input id="email" type="email" wire:model="email" 
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required autofocus>
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Send Reset Link
                </button>
                
                <a href="{{ route('frontdesk.login') }}" 
                   class="text-blue-600 hover:underline">
                    Back to Login
                </a>
            </div>
        </form>
    @else
        <div class="p-4 bg-green-100 text-green-700 rounded-lg">
            We've emailed your password reset link to <strong>{{ $email }}</strong>!
        </div>
        <div class="mt-4 text-center">
            <a href="{{ route('frontdesk.login') }}" 
               class="text-blue-600 hover:underline">
                Return to login
            </a>
        </div>
    @endif
   </div>
</div>