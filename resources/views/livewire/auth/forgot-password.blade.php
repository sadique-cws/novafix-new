<div class="min-h-screen flex flex-col sm:justify-center items-center sm:pt-0 bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-lg overflow-hidden sm:rounded-lg">
        <div class="flex justify-center mb-8">
            <div class="w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center">
                <!-- SVG Icon -->
            </div>
        </div>

        <h1 class="text-center text-2xl  text-gray-800 mb-2">Reset Your Password</h1>
        <p class="text-center text-gray-600 mb-8">Enter your email to receive a password reset link</p>

        @if ($success)
            <div class="mb-6 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                Password reset link has been sent to your email.
            </div>
        @endif

        @if ($error)
            <div class="mb-6 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                {{ $error }}
            </div>
        @endif

        <form wire:submit.prevent="sendResetLink">
            <!-- Email Input -->
            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <div class="relative">
                    <input 
                        id="email" 
                        type="email" 
                        wire:model="email" 
                        required 
                        autofocus
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="you@example.com"
                    >
                </div>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                wire:loading.attr="disabled"
                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300"
            >
                Send Password Reset Link
            </button>

            <!-- Back to Login -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Back to Login
                </a>
            </div>
        </form>
    </div>
</div>