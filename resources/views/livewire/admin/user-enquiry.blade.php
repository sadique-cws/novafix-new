<div class="overflow-x-auto rounded-lg shadow border border-gray-200">
    <table class="w-full text-sm text-left text-gray-700">
        <thead class="bg-gray-100 text-gray-800">
            <tr>
                <th class="px-4 py-2">Id</th>
                <th class="px-4 py-2">User Name</th>
                <th class="px-4 py-2">Contact</th>
                <th class="px-4 py-2">Company</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Subject</th>
                <th class="px-4 py-2">Message</th>
                <th class="px-4 py-2">About Us</th>
                <th class="px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($enquiries as $enquiry)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $enquiry->id }}</td>
                    <td class="px-4 py-2">{{ $enquiry->name }}</td>
                    <td class="px-4 py-2">{{ $enquiry->phone }}</td>
                    <td class="px-4 py-2">{{ $enquiry->company }}</td>
                    <td class="px-4 py-2">{{ $enquiry->email }}</td>
                    <td class="px-4 py-2">{{ $enquiry->subject }}</td>
                    <td class="px-4 py-2">{{ $enquiry->message }}</td>
                    <td class="px-4 py-2">{{ $enquiry->about_us }}</td>
                    <td class="px-4 py-2">
                        <!-- Example Action button -->
                        <button class="px-2 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700">
                            View
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>