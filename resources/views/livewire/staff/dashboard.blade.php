<div class="flex-1 ml-0 p-4 md:p-6">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Staff Dashboard</h2>
            <p class="text-gray-600">Manage your tasks and activities</p>
        </div>
        <div class="mt-4 md:mt-0">
            <div class="flex space-x-2">
                <button class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition flex items-center">
                    <i class="fas fa-plus mr-2"></i> New Report
                </button>
                <button class="px-4 py-2 border border-purple-600 text-purple-600 rounded-lg hover:bg-purple-50 transition flex items-center">
                    <i class="fas fa-filter mr-2"></i> Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Pending Tasks</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $pendingTasksCount }}</p>
                </div>
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">In Progress</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $inProgressTasksCount }}</p>
                </div>
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-spinner text-xl"></i>
                </div>
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Completed Today</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $completedTodayCount }}</p>
                </div>
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Recent Tasks -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Recent Tasks</h3>
                    <a wire:navigate href="{{ route('staff.assigned.task') }}" class="text-sm text-purple-600 hover:text-purple-700">View All</a>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($recentTasks as $task)
                    <div class="px-6 py-4 hover:bg-gray-50 transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="flex items-center">
                                    <span class="font-medium text-gray-900">{{ $task->service_code }}</span>
                                    <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
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
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">{{ $task->owner_name }}</p>
                                <p class="text-xs text-gray-500">{{ $task->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <div class="mt-2 flex justify-between items-center">
                            <div class="flex items-center">
                                <i class="fas fa-tools text-gray-400 mr-1 text-sm"></i>
                                <span class="text-xs text-gray-500">{{ Str::limit($task->problem, 30) }}</span>
                            </div>
                            <a wire:navigate href="{{ route('staff.task.show', $task->id) }}" class="text-xs text-purple-600 hover:text-purple-700 flex items-center">
                                View Details
                                <i class="fas fa-chevron-right ml-1 text-xs"></i>
                            </a>
                        </div>
                        @if($task->technician_notes)
                        <div class="mt-2 pt-2 border-t border-gray-100">
                            <p class="text-xs text-gray-500"><span class="font-medium">Notes:</span> {{ Str::limit($task->technician_notes, 50) }}</p>
                        </div>
                        @endif
                    </div>
                    @empty
                    <div class="px-6 py-4 text-center text-gray-500">
                        No recent tasks found
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Performance Chart -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Weekly Performance</h3>
                </div>
                <div class="p-6">
                    <div class="h-[250px] bg-gray-100 rounded flex items-center justify-center text-gray-400">
                        Performance Chart Placeholder
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                </div>
                <div class="p-4 grid grid-cols-2 gap-3">
                    <a wire:navigate href="" class="p-3 border rounded-lg text-center hover:bg-gray-50 transition">
                        <div class="mx-auto w-10 h-10 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mb-2">
                            <i class="fas fa-plus"></i>
                        </div>
                        <span class="text-sm font-medium">New Task</span>
                    </a>
                    <a wire:navigate href="" class="p-3 border rounded-lg text-center hover:bg-gray-50 transition">
                        <div class="mx-auto w-10 h-10 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mb-2">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <span class="text-sm font-medium">Inventory</span>
                    </a>
                    <a wire:navigate href="" class="p-3 border rounded-lg text-center hover:bg-gray-50 transition">
                        <div class="mx-auto w-10 h-10 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mb-2">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <span class="text-sm font-medium">Reports</span>
                    </a>
                    <a wire:navigate href="" class="p-3 border rounded-lg text-center hover:bg-gray-50 transition">
                        <div class="mx-auto w-10 h-10 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mb-2">
                            <i class="fas fa-cog"></i>
                        </div>
                        <span class="text-sm font-medium">Settings</span>
                    </a>
                </div>
            </div>

            <!-- Upcoming Deliveries -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Upcoming Deliveries</h3>
                    <a wire:navigate href="{{ route('staff.assigned.task') }}" class="text-sm text-purple-600 hover:text-purple-700">View All</a>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($upcomingDeliveries as $delivery)
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-900">{{ $delivery->service_code }}</p>
                                <p class="text-sm text-gray-600">{{ $delivery->product_name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium {{ $delivery->date_of_delivery->isToday() ? 'text-green-600' : 'text-gray-900' }}">
                                    {{ $delivery->date_of_delivery->format('M j') }}
                                </p>
                                <p class="text-xs text-gray-500">{{ $delivery->date_of_delivery->format('h:i A') }}</p>
                            </div>
                        </div>
                        <div class="mt-2 flex items-center justify-between">
                            <span class="text-xs px-2 py-1 bg-amber-100 text-amber-800 rounded-full">
                                {{ $delivery->status }}% complete
                            </span>
                            <a wire:navigate href="{{ route('staff.task.show', $delivery->id) }}" class="text-xs text-purple-600 hover:text-purple-700">Prepare</a>
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-4 text-center text-gray-500">
                        No upcoming deliveries
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>