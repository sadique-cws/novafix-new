<div>
    <h1 class="text-2xl font-bold mb-4">Manage Service Requests</h1>

    <form wire:submit.prevent="createServiceRequest" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="service_code" class="block text-sm font-medium text-gray-700">Service Code</label>
                <input type="text" wire:model="service_code" id="service_code" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500" required>
            </div>
            <div>
                <label for="owner_name" class="block text-sm font-medium text-gray-700">Owner Name</label>
                <input type="text" wire:model="owner_name" id="owner_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500" required>
            </div>
            <div>
                <label for="product_name" class="block text-sm font-medium text-gray-700">Product Name</label>
                <input type="text" wire:model="product_name" id="product_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500" required>
            </div>
            <div>
                <label for="contact" class="block text-sm font-medium text-gray-700">Contact</label>
                <input type="text" wire:model="contact" id="contact" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500" required>
            </div>
            <div>
                <label for="brand" class="block text-sm font-medium text-gray-700">Brand</label>
                <input type="text" wire:model="brand" id="brand" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500" required>
            </div>
            <div>
                <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                <input type="text" wire:model="color" id="color" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500" required>
            </div>
            <div>
                <label for="problem" class="block text-sm font-medium text-gray-700">Problem</label>
                <input type="text" wire:model="problem" id="problem" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500" required>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" wire:model="email" id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500">
            </div>
            <div>
                <label for="service_amount" class="block text-sm font-medium text-gray-700">Service Amount</label>
                <input type="number" step="0.01" wire:model="service_amount" id="service_amount" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500">
            </div>
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                <input type="file" wire:model="image" id="image" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500">
            </div>
        </div>
        <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md">Create Service Request</button>
    </form>

    <h2 class="text-xl font-bold mb-4">Service Requests List</h2>
    <table class="min-w-full bg-white border border-gray-300">
        <thead>
            <tr>
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Service Code</th>
                <th class="border px-4 py-2">Owner Name</th>
                <th class="border px-4 py-2">Product Name</th>
                <th class="border px-4 py-2">Contact</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($serviceRequests as $request)
                <tr>
                    <td class="border px-4 py-2">{{ $request->id }}</td>
                    <td class="border px-4 py-2">{{ $request->service_code }}</td>
                    <td class="border px-4 py-2">{{ $request->owner_name }}</td>
                    <td class="border px-4 py-2">{{ $request->product_name }}</td>
                    <td class="border px-4 py-2">{{ $request->contact }}</td>
                    <td class="border px-4 py-2">{{ $request->status }}</td>
                    <td class="border px-4 py-2">
                        <button wire:click="deleteServiceRequest({{ $request->id }})" class="text-red-600 hover:text-red-800">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
