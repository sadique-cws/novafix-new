<div class="min-h-screen bg-gray-50 p-4 md:p-6">
    <!-- Page Header -->
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Staff Dashboard</h1>
            </div>
            <div class="mt-4 md:mt-0 flex space-x-3">
                <button class="px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:opacity-90 transition flex items-center shadow-md hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    New Report
                </button>
                <button class="px-4 py-2 border border-gray-300 bg-white text-gray-700 rounded-lg hover:bg-gray-50 transition flex items-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                    </svg>
                    Filter
                </button>
            </div>
        </div>

        <!-- Status Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Pending Tasks</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $pendingTasksCount }}</p>
                        <p class="text-xs text-gray-500 mt-1">+2 from yesterday</p>
                    </div>
                    <div class="p-3 rounded-full bg-purple-50 text-purple-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">In Progress</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $inProgressTasksCount }}</p>
                        <p class="text-xs text-gray-500 mt-1">5 completed today</p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Completed Today</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $completedTodayCount }}</p>
                        <p class="text-xs text-gray-500 mt-1">+20% this week</p>
                    </div>
                    <div class="p-3 rounded-full bg-green-50 text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Recent Tasks -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Tasks</h3>
                        <a wire:navigate href="{{ route('staff.assigned.task') }}" class="text-sm font-medium text-purple-600 hover:text-purple-700 flex items-center">
                            View All
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @forelse($recentTasks as $task)
                        <div class="px-6 py-4 hover:bg-gray-50 transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center">
                                        <span class="font-medium text-gray-900 truncate">{{ $task->service_code }}</span>
                                        <span class="ml-2 px-2.5 py-0.5 inline-flex text-xs leading-4 font-medium rounded-full 
                                            @if($task->status == 0) bg-gray-100 text-gray-800
                                            @elseif($task->status == 25) bg-blue-100 text-blue-800
                                            @elseif($task->status == 50) bg-yellow-100 text-yellow-800
                                            @elseif($task->status == 75) bg-indigo-100 text-indigo-800
                                            @elseif($task->status == 90) bg-red-100 text-red-800
                                            @elseif($task->status == 100) bg-green-100 text-green-800 @endif">
                                            @if($task->status == 0) Pending
                                            @elseif($task->status == 25) Processing
                                            @elseif($task->status == 50) In Repair
                                            @elseif($task->status == 75) Testing
                                            @elseif($task->status == 90) Rejected
                                            @elseif($task->status == 100) Completed
                                            @endif
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">{{ $task->product_name }} ({{ $task->brand }})</p>
                                    
                                    <div class="mt-2 flex items-center text-sm text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                        </svg>
                                        <span class="truncate">{{ Str::limit($task->problem, 40) }}</span>
                                    </div>
                                    
                                    @if($task->technician_notes)
                                    <div class="mt-2 pt-2 border-t border-gray-100">
                                        <p class="text-xs text-gray-500"><span class="font-medium">Notes:</span> {{ Str::limit($task->technician_notes, 60) }}</p>
                                    </div>
                                    @endif
                                </div>
                                <div class="ml-4 flex-shrink-0 flex flex-col items-end">
                                    <p class="text-sm font-medium text-gray-900">{{ $task->owner_name }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $task->created_at->diffForHumans() }}</p>
                                    <a wire:navigate href="{{ route('staff.task.show', $task->id) }}" class="mt-2 inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                        Details
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="px-6 py-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No recent tasks</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new task.</p>
                            <div class="mt-6">
                                <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                    New Task
                                </button>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Upcoming Deliveries -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-900">Upcoming Deliveries</h3>
                        <a wire:navigate href="{{ route('staff.assigned.task') }}" class="text-sm font-medium text-purple-600 hover:text-purple-700 flex items-center">
                            View All
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @forelse($upcomingDeliveries as $delivery)
                        <div class="px-6 py-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 pt-0.5">
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-purple-100 text-purple-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1v-1a1 1 0 011-1h2a1 1 0 011 1v1a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H19a1 1 0 001-1V5a1 1 0 00-1-1H3z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $delivery->service_code }}</p>
                                        <div class="ml-2 flex-shrink-0 flex">
                                            <p class="text-xs font-medium {{ $delivery->date_of_delivery ? 'text-green-600' : 'text-gray-500' }}">
                                                {{ $delivery->date_of_delivery }}
                                                <span class="font-normal">{{ $delivery->date_of_delivery }}</span>
                                            </p>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-0.5">{{ $delivery->product_name }}</p>
                                    
                                    <div class="mt-2 flex items-center justify-between">
                                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                                            <div class="bg-purple-600 h-1.5 rounded-full" style="width: {{ $delivery->status }}%"></div>
                                        </div>
                                        <span class="ml-3 text-xs font-medium text-gray-500">{{ $delivery->status }}%</span>
                                    </div>
                                    
                                    <div class="mt-2 flex justify-end">
                                        <a wire:navigate href="{{ route('staff.task.show', $delivery->id) }}" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                            Prepare
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="px-6 py-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No upcoming deliveries</h3>
                            <p class="mt-1 text-sm text-gray-500">All caught up for now!</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>