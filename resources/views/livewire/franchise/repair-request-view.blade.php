<div class="p-6">
    <h2 class="text-2xl font-bold mb-6">Service Request Details</h2>

    <div class="grid grid-cols-2 gap-4 bg-white shadow rounded-xl p-6">
        <div>
            <p><strong>ID:</strong> {{ $request->id }}</p>
            <p><strong>Service Code:</strong> {{ $request->service_code }}</p>
            <p><strong>Owner Name:</strong> {{ $request->owner_name }}</p>
            <p><strong>Product:</strong> {{ $request->product_name }}</p>
            <p><strong>Brand:</strong> {{ $request->brand }}</p>
            <p><strong>Color:</strong> {{ $request->color }}</p>
            <p><strong>Email:</strong> {{ $request->email ?? '-' }}</p>
            <p><strong>Contact:</strong> {{ $request->contact }}</p>
            <p><strong>Problem:</strong> {{ $request->problem }}</p>
            <p><strong>Remark:</strong> {{ $request->remark ?? '-' }}</p>
        </div>

        <div>
            <p><strong>Service Amount:</strong> {{ $request->service_amount ?? 'N/A' }}</p>
            <p><strong>Status:</strong>
                {{ $request->status == 0 ? 'Pending' : 'Completed' }}
            </p>
            <p><strong>Delivery Status:</strong>
                {{ $request->delivery_status ? 'Delivered' : 'Not Delivered' }}
            </p>
            <p><strong>Updated At:</strong> {{ $request->updated_at }}</p>

            <p><strong>Image:</strong></p>
            @if ($request->image)
                <img src="{{ $request->image }}" alt="Service Image" class="h-32 w-32 object-cover rounded">
            @else
                <p>No Image</p>
            @endif


        </div>
          {{-- Receptioner Update --}}
    <div class="mt-6 bg-gray-100 p-4 rounded">
        <h3 class="text-lg font-semibold mb-2">Assign Receptioner</h3>
        <form wire:submit.prevent="updateReceptioner" class="flex items-center gap-4">
            <select wire:model="receptioner_id" class="border rounded p-2">
                <option value="">-- Select Receptioner --</option>
                @foreach($receptioners as $receptioner)
                    <option value="{{ $receptioner->id }}">
                        {{ $receptioner->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" 
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Update
            </button>
        </form>

        @if (session()->has('success'))
            <p class="text-green-600 mt-2">{{ session('success') }}</p>
        @endif
    </div>
    </div>

    <div class="mt-6">
        <a wire:navigate href="{{ route('franchise.repair-requests') }}"
            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            ← Back to Requests
        </a>
    </div>
</div>
