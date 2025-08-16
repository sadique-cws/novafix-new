<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-lg font-semibold mb-4">Confirm Delete</h2>
        <p class="mb-4">Are you sure you want to delete this device?</p>
        <div class="flex justify-end space-x-2">
            <button wire:click="$dispatch('closeDeleteModal')" class="px-4 py-2 bg-gray-300 rounded">Cancel</button>
            <button wire:click="delete" wire:loading.attr="disabled" wire:loading.class="opacity-75 cursor-not-allowed"
                class="px-4 py-2 bg-red-500 text-white rounded">
                <span wire:loading.remove>Delete</span>
                <span wire:loading>
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Deleting...
                </span>
            </button>
        </div>
    </div>
</div>