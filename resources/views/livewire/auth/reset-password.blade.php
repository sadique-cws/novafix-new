<div>
  

    <!-- Page Content -->
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-lg space-y-8">
            
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900">Reset Password</h2>
            </div>

            {{-- Error --}}
            @if ($error)
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm" role="alert">
                    {{ $error }}
                </div>
                <div class="text-center">
                    <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Request a new reset link
                    </a>
                </div>
            
            {{-- Valid token --}}
            @elseif($validToken)
                @if ($message)
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm" role="alert">
                        {{ $message }}
                    </div>
                @else
                    <form class="mt-6 space-y-6" wire:submit.prevent="resetPassword">
                        
                        <div class="space-y-4">
                            <div>
                                <label for="password" class="sr-only">New Password</label>
                                <input id="password" name="password" type="password" autocomplete="new-password" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                       placeholder="New Password" wire:model="password">
                                @error('password') 
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="sr-only">Confirm Password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                       placeholder="Confirm Password" wire:model="password_confirmation">
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                    class="relative w-full flex justify-center items-center py-5 px-4 text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-300 transition duration-200 ease-in-out">
                                <span wire:loading.remove>Reset Password</span>

                                <!-- Small button spinner -->
                                <svg wire:loading class="animate-spin h-7 w-7 text-white absolute" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                @endif
            @endif
        </div>
    </div>
</div>
