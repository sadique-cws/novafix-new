<div class="p-10 ">

    @if (session()->has('message'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-400 rounded-lg">
            {{ session('message') }}
        </div>
    @endif
    <div class="flex gap-5">
        <div class="w-3/12">
            <h2>Insert Devices</h2>
            <form class="border p-2 flex flex-col gap-4" wire:submit.prevent="addDevice">
                <div class="flex flex-col gap-2">
                    <label for="">Enter Device</label>
                    <input type="text" wire:model="name" placeholder="device" class="p-2 rounded border">
                </div>
                <div>
                    <button class="bg-teal-600 font-semibold text-lg rounded px-2 py-1 rounded w-full">Add</button>
                </div>
            </form>
        </div>
        <div class="w-9/12">
            <h2>Manage Devices</h2>
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="border p-2">Id</th>
                        <th class="border p-2">Device name</th>
                        <th class="border p-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($devices as $device)
                        <tr>
                            <td class="border p-2">{{ $device->id }}</td>
                            <td class="border p-2">{{ $device->name }}</td>
                            <td class="border p-2">
                                <button class="bg-red-500 text-white p-1 rounded"
                                    wire:click="deleteDevice({{ $device->id }})">
                                    Delete
                                </button>
                                <button class="bg-yellow-500 text-white p-1 rounded"
                                    wire:click="editDevice({{ $device->id }})">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>