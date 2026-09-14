<div class="space-y-6">
    <!-- Status Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <div class="bg-white border border-gray-200 rounded-lg p-6 h-32 flex flex-col justify-center">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-full bg-purple-50 flex items-center justify-center text-purple-600">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <p class="text-sm font-medium text-gray-500">Pending Tasks</p>
            </div>
            <h3 class="text-3xl font-bold text-gray-900">{{ $pendingTasksCount }}</h3>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-6 h-32 flex flex-col justify-center">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600">
                    <i class="fas fa-spinner"></i>
                </div>
                <p class="text-sm font-medium text-gray-500">In Progress</p>
            </div>
            <h3 class="text-3xl font-bold text-gray-900">{{ $inProgressTasksCount }}</h3>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-6 h-32 flex flex-col justify-center">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                    <i class="fas fa-check-circle"></i>
                </div>
                <p class="text-sm font-medium text-gray-500">Completed Today</p>
            </div>
            <h3 class="text-3xl font-bold text-gray-900">{{ $completedTodayCount }}</h3>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Recent Tasks -->
        <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-base font-bold text-gray-900 uppercase tracking-wide">Recent Tasks</h2>
                <a wire:navigate href="{{ route('staff.assigned.task') }}" class="text-sm font-medium text-primary hover:text-primary/80">View All</a>
            </div>
            
            <div class="overflow-x-auto">
                <x-ui.table>
                    <x-slot name="head">
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200 bg-gray-50/50">Service Code</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200 bg-gray-50/50">Product</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200 bg-gray-50/50">Action</th>
                    </x-slot>
                    
                    @forelse($recentTasks as $task)
                        <tr class="hover:bg-gray-50 transition-colors border-b border-gray-100">
                            <td class="px-5 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $task->service_code }}</td>
                            <td class="px-5 py-4 text-sm text-gray-700">
                                <div>{{ $task->product_name }}</div>
                                <div class="text-xs text-gray-500">{{ $task->brand }}</div>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-sm text-right">
                                <a wire:navigate href="{{ route('staff.task.show', $task->id) }}" class="text-primary hover:text-primary/80 font-medium">Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-5 py-8 text-center text-sm text-gray-500">No recent tasks found.</td>
                        </tr>
                    @endforelse
                </x-ui.table>
            </div>
        </div>

        <!-- Upcoming Deliveries -->
        <div class="bg-white rounded-lg border border-gray-200">
            <div class="p-5 border-b border-gray-100 flex justify-between items-center">
                <h2 class="text-base font-bold text-gray-900 uppercase tracking-wide">Upcoming Deliveries</h2>
                <a wire:navigate href="{{ route('staff.assigned.task') }}" class="text-sm font-medium text-primary hover:text-primary/80">View All</a>
            </div>
            
            <div class="p-0">
                @forelse($upcomingDeliveries as $delivery)
                    <div class="p-5 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="text-sm font-bold text-gray-900">#{{ $delivery->service_code }}</p>
                                <p class="text-xs text-gray-500">{{ $delivery->product_name }}</p>
                            </div>
                            <span class="text-xs font-bold {{ $delivery->status == 100 ? 'text-green-600' : 'text-blue-600' }}">{{ $delivery->status }}%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                            <div class="h-1.5 rounded-full {{ $delivery->status == 100 ? 'bg-green-500' : 'bg-blue-500' }}" style="width: {{ $delivery->status }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-sm text-gray-500">No upcoming deliveries.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>