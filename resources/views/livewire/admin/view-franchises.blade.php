<div>
    @if($franchise)
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <!-- Header with status -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center mr-4">
                        <span class="text-blue-600 text-xl font-bold">{{ substr($franchise->franchise_name, 0, 1) }}</span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $franchise->franchise_name }}</h1>
                        <div class="flex items-center text-sm text-gray-500 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            Created {{ $franchise->created_at->format('M d, Y') }}
                        </div>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full text-sm font-medium 
                    {{ $franchise->status === 'active' ? 'bg-green-100 text-green-800' : 
                       ($franchise->status === 'inactive' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                    {{ ucfirst($franchise->status) }}
                </span>
            </div>

            <!-- Rest of your view content -->
        </div>
    @else
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <p class="text-red-500">No franchise found</p>
            <a href="{{ route('admin.franchises.index') }}" class="text-blue-600 hover:underline mt-4 inline-block">
                Back to franchises list
            </a>
        </div>
    @endif
</div>