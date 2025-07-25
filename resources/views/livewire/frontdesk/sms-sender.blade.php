<div>
    <form wire:submit.prevent="sendSms">
        <div class="mb-4">
            <label for="mobile" class="block text-sm font-medium text-gray-700">Mobile Number</label>
            <input wire:model="mobile" type="text" id="mobile" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            @error('mobile') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
            <textarea wire:model="message" id="message" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
            @error('message') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
            Send SMS
        </button>

        @if($response)
            <div class="mt-4 p-4 {{ $isSuccess ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded">
                {{ $response }}
            </div>
        @endif
    </form>
</div>