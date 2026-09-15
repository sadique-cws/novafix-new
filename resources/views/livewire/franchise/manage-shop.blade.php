<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold text-gray-800">Manage Shops (B2B)</h2>
        <x-ui.button wire:click="openModal">Add New Shop</x-ui.button>
    </div>

    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white rounded-lg border border-gray-200 overflow-x-auto">
        <x-ui.table>
            <x-slot name="head">
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Shop Name</th>
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Owner</th>
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Contact</th>
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Email</th>
                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase">Address</th>
                <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
            </x-slot>

            @forelse($shops as $shop)
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="px-5 py-4 text-sm text-gray-900 font-medium">{{ $shop->shop_name }}</td>
                    <td class="px-5 py-4 text-sm text-gray-700">{{ $shop->owner_name }}</td>
                    <td class="px-5 py-4 text-sm text-gray-700">{{ $shop->contact }}</td>
                    <td class="px-5 py-4 text-sm text-gray-700">{{ $shop->email ?? 'N/A' }}</td>
                    <td class="px-5 py-4 text-sm text-gray-700">{{ $shop->address ?? 'N/A' }}</td>
                    <td class="px-5 py-4 text-sm text-right">
                        <a href="{{ route('franchise.view.shop', $shop->id) }}" wire:navigate class="text-blue-600 hover:text-blue-900 font-semibold text-sm">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-5 py-8 text-center text-sm text-gray-500">No shops found.</td>
                </tr>
            @endforelse
        </x-ui.table>
    </div>

    <!-- Add/Edit Modal -->
    <x-ui.modal name="shopModal" title="{{ $shop_id ? 'Edit Shop' : 'Add New Shop' }}">
        <form wire:submit.prevent="save" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Shop Name</label>
                <x-ui.input type="text" wire:model="shop_name" placeholder="Enter shop name" />
                @error('shop_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Owner Name</label>
                <x-ui.input type="text" wire:model="owner_name" placeholder="Enter owner name" />
                @error('owner_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                <x-ui.input type="text" wire:model="contact" placeholder="Enter contact number" />
                @error('contact') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email (Optional)</label>
                <x-ui.input type="email" wire:model="email" placeholder="Enter email" />
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Address (Optional)</label>
                <x-ui.input type="text" wire:model="address" placeholder="Enter address" />
                @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">GST Number (Optional)</label>
                <x-ui.input type="text" wire:model="gst_number" placeholder="Enter GST number" />
                @error('gst_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <x-ui.button type="button" variant="secondary" wire:click="closeModal">Cancel</x-ui.button>
                <x-ui.button type="submit">Save</x-ui.button>
            </div>
        </form>
    </x-ui.modal>
</div>