<div class="bg-[#F9FAFB] min-h-screen py-6 px-2 sm:px-4 lg:px-0">
    {{-- Success Message --}}
    @if(session()->has('success'))
        <div class="mb-4 px-4 py-3 bg-[#10B981] text-white rounded shadow-sm text-center">
            {{ session('success') }}
        </div>
    @endif

    {{-- Franchise Profile Card --}}
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg p-6 sm:p-8 mb-8 border border-[#F1F5F9]">
        <h2 class="text-2xl font-bold text-[#1E40AF] mb-6">Franchise Profile</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4 text-[#111827]">
            <div><span class="font-semibold">Franchise Name:</span> {{ $franchise->franchise_name }}</div>
            <div><span class="font-semibold">Email:</span> {{ $franchise->email }}</div>
            <div><span class="font-semibold">Contact No:</span> {{ $franchise->contact_no }}</div>
            <div><span class="font-semibold">Aadhar No:</span> {{ $franchise->aadhar_no ?? '-' }}</div>
            <div><span class="font-semibold">PAN No:</span> {{ $franchise->pan_no ?? '-' }}</div>
            <div><span class="font-semibold">Bank Name:</span> {{ $franchise->bank_name ?? '-' }}</div>
            <div><span class="font-semibold">Account No:</span> {{ $franchise->account_no ?? '-' }}</div>
            <div><span class="font-semibold">IFSC Code:</span> {{ $franchise->ifsc_code ?? '-' }}</div>
            <div><span class="font-semibold">Street:</span> {{ $franchise->street ?? '-' }}</div>
            <div><span class="font-semibold">City:</span> {{ $franchise->city ?? '-' }}</div>
            <div><span class="font-semibold">District:</span> {{ $franchise->district ?? '-' }}</div>
            <div><span class="font-semibold">State:</span> {{ $franchise->state ?? '-' }}</div>
            <div><span class="font-semibold">Pincode:</span> {{ $franchise->pincode ?? '-' }}</div>
            <div><span class="font-semibold">Country:</span> {{ $franchise->country ?? '-' }}</div>
            <div><span class="font-semibold">Date of Creation:</span> {{ $franchise->doc ?? '-' }}</div>
            <div>
                <span class="font-semibold">Status:</span>
                <span class="
                    px-2 py-1 rounded text-xs
                    @if($franchise->status == 'active') bg-[#10B981] text-white
                    @elseif($franchise->status == 'inactive') bg-[#F87171] text-white
                    @else bg-[#FBBF24] text-white @endif">
                    {{ ucfirst($franchise->status) }}
                </span>
            </div>
        </div>
    </div>

    {{-- Change Password Card --}}
    <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg p-6 sm:p-8 border border-[#F1F5F9]">
        <h2 class="text-xl font-semibold text-[#1E40AF] mb-3">Change Password</h2>
        <p class="text-[#3B82F6] mb-6">For security, it's a good idea to update your password regularly.</p>
        <button
            wire:click="$set('showChangePasswordModal', true)"
            class="w-full sm:w-auto px-6 py-2 bg-[#1E40AF] rounded-lg text-white font-medium hover:bg-[#3B82F6] transition">
            Change Password
        </button>
    </div>

    {{-- Modal Overlay --}}
    @if($showChangePasswordModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-30 z-50">
            <div class="bg-white w-full max-w-md p-6 rounded-xl shadow-2xl border-2 border-[#3B82F6] relative">
                <button wire:click="$set('showChangePasswordModal', false)"
                    class="absolute top-3 right-3 text-[#3B82F6] hover:text-[#1E40AF] text-xl font-bold">&times;</button>
                <h3 class="text-lg font-semibold text-[#1E40AF] mb-4">Change Password</h3>
                <form wire:submit.prevent="updatePassword" class="space-y-4">
                    <div>
                        <label class="block text-[#111827] font-medium mb-1">Current Password</label>
                        <input type="password" wire:model.defer="current_password"
                            class="w-full border border-[#3B82F6] rounded px-3 py-2 focus:ring-2 focus:ring-[#1E40AF] focus:border-[#1E40AF] text-[#111827]"
                            autocomplete="current-password">
                        @error('current_password')
                            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-[#111827] font-medium mb-1">New Password</label>
                        <input type="password" wire:model.defer="new_password"
                            class="w-full border border-[#3B82F6] rounded px-3 py-2 focus:ring-2 focus:ring-[#1E40AF] focus:border-[#1E40AF] text-[#111827]"
                            autocomplete="new-password">
                        @error('new_password')
                            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-[#111827] font-medium mb-1">Confirm New Password</label>
                        <input type="password" wire:model.defer="new_password_confirmation"
                            class="w-full border border-[#3B82F6] rounded px-3 py-2 focus:ring-2 focus:ring-[#1E40AF] focus:border-[#1E40AF] text-[#111827]">
                        @error('new_password_confirmation')
                            <div class="text-red-600 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="flex items-center justify-between mt-6">
                        <button type="submit"
                            class="w-full px-6 py-2 bg-[#10B981] rounded-lg text-white font-semibold hover:bg-[#1E40AF] transition">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            // Trap scroll under modal (optional for extra polish)
            document.body.classList.add('overflow-hidden');
        </script>
    @else
        <script>
            document.body.classList.remove('overflow-hidden');
        </script>
    @endif
</div>
