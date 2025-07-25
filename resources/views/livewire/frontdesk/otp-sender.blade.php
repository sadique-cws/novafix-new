<div class="max-w-md mx-auto p-4 bg-white shadow-md rounded-lg">
    @if(!$otpSent)
        <h2 class="text-xl font-bold mb-4">Enter Phone Number</h2>
        <form wire:submit.prevent="sendOtp">
            <input wire:model="phone" type="tel" placeholder="9876543210" 
                   class="w-full p-2 border rounded mb-2">
            @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            <button type="submit" class="bg-blue-500 text-white p-2 rounded w-full">
                Send OTP
            </button>
        </form>
    @else
        <div class="p-4 bg-green-100 text-green-800 rounded mb-4">
            {{ $status }}
        </div>
        <!-- Add OTP verification form here if needed -->
    @endif
</div>