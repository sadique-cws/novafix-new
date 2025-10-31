<div class="min-h-screen bg-gray-50 p-4 md:p-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <h1 class="text-2xl md:text-3xl text-gray-800">Staff Dashboard</h1>
    </div>

    <!-- Status Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
        <div class="bg-white p-5 rounded-lg border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Pending Tasks</p>
                    <p class="text-2xl text-gray-800 mt-1">{{ $pendingTasksCount }}</p>
                </div>
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-lg border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">In Progress</p>
                    <p class="text-2xl text-gray-800 mt-1">{{ $inProgressTasksCount }}</p>
                </div>
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9H9m11 11v-5h-.581a8.003 8.003 0 01-15.357-2H15" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-lg border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Completed Today</p>
                    <p class="text-2xl text-gray-800 mt-1">{{ $completedTodayCount }}</p>
                </div>
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Tasks -->
        <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200">
            <div class="flex justify-between items-center px-6 py-4 border-b bg-gray-50">
                <h3 class="text-lg text-gray-900">Recent Tasks</h3>
                <a href="{{ route('staff.assigned.task') }}" class="text-sm text-purple-600 hover:underline">View
                    All</a>
            </div>
            <div>
                @forelse($recentTasks as $task)
                    <div class="px-6 py-4 border-b last:border-0 hover:bg-gray-50">
                        <div class="flex justify-between">
                            <div>
                                <p class="text-gray-900">{{ $task->service_code }}</p>
                                <p class="text-sm text-gray-600">{{ $task->product_name }} ({{ $task->brand }})</p>
                            </div>
                            <a href="{{ route('staff.task.show', $task->id) }}"
                                class="text-sm text-purple-600 hover:underline">Details</a>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">No recent tasks</div>
                @endforelse
            </div>
        </div>

        <!-- Upcoming Deliveries -->
        <div class="bg-white rounded-lg border border-gray-200">
            <div class="flex justify-between items-center px-6 py-4 border-b bg-gray-50">
                <h3 class="text-lg text-gray-900">Upcoming Deliveries</h3>
                <a href="{{ route('staff.assigned.task') }}" class="text-sm text-purple-600 hover:underline">View
                    All</a>
            </div>
            <div>
                @forelse($upcomingDeliveries as $delivery)
                    <div class="px-6 py-4 border-b last:border-0">
                        <p class="text-gray-900">{{ $delivery->service_code }}</p>
                        <p class="text-sm text-gray-600">{{ $delivery->product_name }}</p>
                        <div class="mt-2 flex items-center">
                            <div class="w-full bg-gray-200 h-1.5 rounded-full">
                                <div class="bg-purple-600 h-1.5 rounded-full" style="width: {{ $delivery->status }}%">
                                </div>
                            </div>
                            <span class="ml-3 text-xs text-gray-500">{{ $delivery->status }}%</span>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">No upcoming deliveries</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
