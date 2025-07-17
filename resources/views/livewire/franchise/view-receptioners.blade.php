<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Receptionist Details</h2>
            <a wire:navigate href="{{ route('franchise.manage.receptioners') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                Back to List
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Personal Information -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Personal Information</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Name</p>
                        <p class="text-gray-800">{{ $receptionist->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="text-gray-800">{{ $receptionist->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Contact</p>
                        <p class="text-gray-800">{{ $receptionist->contact }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Aadhar Number</p>
                        <p class="text-gray-800">{{ $receptionist->aadhar }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">PAN Number</p>
                        <p class="text-gray-800">{{ $receptionist->pan }}</p>
                    </div>
                </div>
            </div>

            <!-- Employment Details -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Employment Details</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Salary</p>
                        <p class="text-gray-800">₹{{ number_format($receptionist->salary, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $receptionist->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $receptionist->status ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Joined On</p>
                        <p class="text-gray-800">{{ $receptionist->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Address -->
            <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Address</h3>
                <p class="text-gray-800 whitespace-pre-line">{{ $receptionist->address }}</p>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-4">
            <a wire:navigate href="" 
               class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Edit
            </a>
            <button wire:click="confirmDelete({{ $receptionist->id }})" 
                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                Delete
            </button>
        </div>
    </div>
</div>