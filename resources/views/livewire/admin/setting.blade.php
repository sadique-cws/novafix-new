<div class="max-w-lg mx-auto bg-white shadow rounded-2xl p-6 space-y-6">
    <!-- Profile Info -->
    <div>
        <h2 class="text-lg font-semibold mb-4">Profile Information</h2>
        @if (session('message'))
            <p class="text-green-500 font-medium">{{ session('message') }}</p>
        @endif
        <form wire:submit="updateName">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" wire:model="name"
                        class="mt-1 p-2 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Your Name">
                    @error('name')
                        <div class="text-red-500 font-medium">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email (Read Only) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" wire:model="email"
                        class="mt-1 p-2 block w-full rounded-lg border-gray-300 bg-gray-100 cursor-not-allowed"
                        value="{{$email}}" disabled>
                </div>
                <button type="submit" class="bg-[#1E40AF] font-medium p-2 text-white w-full rounded">Save</button>
            </div>
        </form>

    </div>

    <!-- Change Password -->
    <div>
        <h2 class="text-lg font-semibold mb-4">Change Password</h2>

        <form wire:submit="changePassword">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Current Password</label>
                    <input type="password" wire:model="currentPassword"
                        class="mt-1 p-2 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter current password">
                    @error('currentPassword')
                        <p class="text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">New Password</label>
                    <input type="password" wire:model="newPassword"
                        class="mt-1 p-2 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter new password">
                    @error('newPassword')
                        <p class="text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                    <input type="password" wire:model="newPassword_confirmation"
                        class="mt-1 p-2 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Re-enter new password">
                    @error('newPassword_confirmation')
                        <p class="text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="bg-[#1E40AF] font-medium p-2 text-white  rounded w-full">Save</button>
            </div>
        </form>
    </div>

</div>