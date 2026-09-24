<div class="p-4 sm:p-6 lg:p-8 space-y-6">
    @if (session()->has('message'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200 flex items-center justify-between" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2 text-green-600"></i>
                <span>{{ session('message') }}</span>
            </div>
            <button type="button" @click="$el.parentElement.remove()" class="text-green-600 hover:text-green-800">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- User Enquiries Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between bg-gray-50">
            <h2 class="text-base font-semibold text-gray-800 flex items-center">
                <i class="fas fa-user-circle text-blue-600 mr-2"></i> All User Enquiries
            </h2>
            <span class="text-xs font-medium text-gray-500 bg-gray-200 px-2.5 py-1 rounded-full">
                {{ count($enquiries) }} {{ Str::plural('Enquiry', count($enquiries)) }}
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3.5 font-semibold"># ID</th>
                        <th class="px-6 py-3.5 font-semibold">User Details</th>
                        <th class="px-6 py-3.5 font-semibold">Contact</th>
                        <th class="px-6 py-3.5 font-semibold">Subject</th>
                        <th class="px-6 py-3.5 font-semibold">Message</th>
                        <th class="px-6 py-3.5 font-semibold">Date</th>
                        <th class="px-6 py-3.5 font-semibold text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($enquiries as $enquiry)
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                #{{ $enquiry->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 font-semibold flex items-center justify-center text-xs">
                                        {{ strtoupper(substr($enquiry->name ?? 'U', 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $enquiry->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $enquiry->email ?? 'No email' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                                <div><i class="fas fa-phone-alt text-xs text-gray-400 mr-1.5"></i>{{ $enquiry->phone ?? 'N/A' }}</div>
                                @if($enquiry->company)
                                    <div class="text-xs text-gray-500 mt-0.5"><i class="fas fa-building text-xs text-gray-400 mr-1.5"></i>{{ $enquiry->company }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-700 font-medium max-w-xs truncate" title="{{ $enquiry->subject }}">
                                {{ $enquiry->subject ?? 'General Enquiry' }}
                            </td>
                            <td class="px-6 py-4 text-gray-600 max-w-xs truncate" title="{{ $enquiry->message }}">
                                {{ $enquiry->message }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                {{ $enquiry->created_at ? $enquiry->created_at->format('M d, Y h:i A') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <button type="button" wire:click="viewEnquiry({{ $enquiry->id }})"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                                    <i class="fas fa-eye mr-1.5"></i> View
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="far fa-folder-open text-4xl text-gray-300 mb-2"></i>
                                    <p class="text-sm font-medium">No user enquiries found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- User Enquiry Details Modal -->
    @if ($showModal && $selectedEnquiry)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs transition-opacity" wire:click="closeModal"></div>

            <div class="flex min-h-screen items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-200">
                    <!-- Modal Header -->
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center text-sm font-bold">
                                <i class="fas fa-envelope-open"></i>
                            </span>
                            <h3 class="text-base font-semibold text-gray-900">User Enquiry Details #{{ $selectedEnquiry->id }}</h3>
                        </div>
                        <button type="button" wire:click="closeModal" class="text-gray-400 hover:text-gray-600 focus:outline-none p-1.5 rounded-lg hover:bg-gray-100 transition-colors">
                            <i class="fas fa-times text-base"></i>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="px-6 py-5 space-y-4">
                        <!-- User Details Snippet -->
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 flex items-start space-x-3.5">
                            <div class="w-11 h-11 rounded-full bg-blue-600 text-white font-bold flex items-center justify-center text-sm flex-shrink-0 shadow-sm">
                                {{ strtoupper(substr($selectedEnquiry->name ?? 'U', 0, 2)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-bold text-gray-900 truncate">{{ $selectedEnquiry->name }}</h4>
                                @if($selectedEnquiry->company)
                                    <p class="text-xs text-gray-500">{{ $selectedEnquiry->company }}</p>
                                @endif
                                
                                <div class="mt-2.5 grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-phone-alt text-gray-400 mr-1.5 w-3.5 text-center"></i>
                                        <a href="tel:{{ $selectedEnquiry->phone ?? '' }}" class="hover:text-blue-600 font-medium truncate">
                                            {{ $selectedEnquiry->phone ?? 'N/A' }}
                                        </a>
                                    </div>
                                    <div class="flex items-center text-gray-600">
                                        <i class="fas fa-envelope text-gray-400 mr-1.5 w-3.5 text-center"></i>
                                        <a href="mailto:{{ $selectedEnquiry->email ?? '' }}" class="hover:text-blue-600 font-medium truncate">
                                            {{ $selectedEnquiry->email ?? 'N/A' }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Subject -->
                        @if($selectedEnquiry->subject)
                            <div>
                                <span class="text-xs font-semibold text-gray-500 uppercase">Subject:</span>
                                <p class="text-sm font-semibold text-gray-900 mt-0.5">{{ $selectedEnquiry->subject }}</p>
                            </div>
                        @endif

                        <!-- How they found us -->
                        @if($selectedEnquiry->about_us)
                            <div class="text-xs text-gray-500">
                                <span>Referred by / Source: </span>
                                <span class="font-medium text-gray-700">{{ $selectedEnquiry->about_us }}</span>
                            </div>
                        @endif

                        <!-- Date Sent -->
                        <div class="flex items-center justify-between text-xs text-gray-500 border-b border-gray-100 pb-2">
                            <span>Received Date:</span>
                            <span class="font-medium text-gray-700">
                                {{ $selectedEnquiry->created_at ? $selectedEnquiry->created_at->format('M d, Y h:i A') : 'N/A' }}
                            </span>
                        </div>

                        <!-- Message Content -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Message Content</label>
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 text-sm text-gray-800 whitespace-pre-wrap leading-relaxed max-h-60 overflow-y-auto">
                                {{ $selectedEnquiry->message }}
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="bg-gray-50 px-6 py-3.5 border-t border-gray-200 flex items-center justify-between">
                        <button type="button"
                            @click="$dispatch('confirm-action', {
                                title: 'Delete User Enquiry',
                                message: 'Are you sure you want to delete this enquiry from {{ addslashes($selectedEnquiry->name ?? 'User') }}? This action cannot be undone.',
                                confirmText: 'Yes, Delete',
                                confirmColor: 'red',
                                action: () => $wire.deleteEnquiry({{ $selectedEnquiry->id }})
                            })"
                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 hover:text-white hover:bg-red-600 border border-red-200 hover:border-transparent rounded-lg transition-colors focus:outline-none cursor-pointer">
                            <i class="fas fa-trash-alt mr-1.5"></i> Delete
                        </button>
                        <button type="button" wire:click="closeModal"
                            class="inline-flex items-center px-4 py-2 text-xs font-semibold text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors shadow-sm focus:outline-none">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>