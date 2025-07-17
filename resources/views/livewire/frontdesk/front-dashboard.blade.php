<main class="flex-1 p-4 md:p-6 overflow-auto ">
  <!-- Stats Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <!-- Card Example -->
    <div class="bg-white rounded-xl shadow-md p-5">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-500">Today's Services</p>
          <h3 class="text-3xl font-bold text-gray-800">24</h3>
        </div>
        <div class="bg-blue-100 p-3 rounded-full">
          <i class="fas fa-tools text-primary text-xl"></i>
        </div>
      </div>
      <p class="mt-3 text-green-600 text-sm flex items-center">
        <i class="fas fa-arrow-up mr-1"></i> 12% from yesterday
      </p>
    </div>

    <!-- Repeat similar cards for In Progress, Completed, Items in Stock -->
    <!-- ... -->
  </div>

  <!-- Quick Actions -->
  <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    <button class="bg-white rounded-xl shadow-md p-4 flex items-center justify-between hover:bg-primary hover:text-white transition">
      <span class="text-sm font-medium">New Service</span>
      <i class="fas fa-plus-circle text-xl"></i>
    </button>
    <!-- Other buttons with similar pattern... -->
  </div>

  <!-- Recent Service Requests + Status Breakdown -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Recent Requests Table -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-md p-5">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-gray-800">Recent Service Requests</h2>
        <button class="text-sm font-medium text-primary hover:underline">View All</button>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead class="text-gray-500">
            <tr>
              <th class="pb-2">Ticket #</th>
              <th class="pb-2">Customer</th>
              <th class="pb-2">Device</th>
              <th class="pb-2">Status</th>
              <th class="pb-2">Date</th>
            </tr>
          </thead>
          <tbody>
            <tr class="hover:bg-gray-50 border-t">
              <td class="py-3">#TC-8271</td>
              <td>John Smith</td>
              <td>MacBook Pro 15"</td>
              <td><span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Diagnosis</span></td>
              <td>Today</td>
            </tr>
            <!-- Repeat rows -->
          </tbody>
        </table>
      </div>
    </div>

    <!-- Status Breakdown -->
    <div class="bg-white rounded-xl shadow-md p-5">
      <h2 class="text-lg font-semibold mb-4 text-gray-800">Service Status</h2>
      <div class="space-y-4">
        <div>
          <div class="flex justify-between mb-1">
            <span class="text-sm text-gray-600">Diagnosis</span>
            <span class="text-sm text-gray-600">4</span>
          </div>
          <div class="h-2 rounded-full bg-gray-200">
            <div class="h-2 rounded-full bg-blue-600" style="width: 20%"></div>
          </div>
        </div>
        <!-- Repeat for Repair, QC, Pickup -->
      </div>
      <div class="mt-6 space-y-2">
        <div class="flex items-center gap-2">
          <span class="w-3 h-3 bg-blue-600 rounded-full"></span>
          <span class="text-sm text-gray-600">Diagnosis (20%)</span>
        </div>
        <!-- Legend rows -->
      </div>
    </div>
  </div>

  <!-- Device Breakdown -->
  <div class="mt-6 bg-white rounded-xl shadow-md p-5">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-lg font-semibold text-gray-800">Device Type Breakdown</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div>
        <img src="https://placehold.co/300x200" alt="Chart" class="w-full rounded-md">
        <p class="text-center text-sm text-gray-500 mt-2">Last 30 days service requests</p>
      </div>
      <div class="flex flex-col justify-center space-y-2">
        <div class="flex items-center text-sm text-gray-600">
          <span class="w-3 h-3 bg-blue-600 rounded-full mr-2"></span> Laptops (45%)
        </div>
        <div class="flex items-center text-sm text-gray-600">
          <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span> Smartphones (30%)
        </div>
        <div class="flex items-center text-sm text-gray-600">
          <span class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></span> Tablets (15%)
        </div>
        <div class="flex items-center text-sm text-gray-600">
          <span class="w-3 h-3 bg-purple-600 rounded-full mr-2"></span> TVs (10%)
        </div>
      </div>
      <div class="flex flex-col justify-center">
        <h3 class="font-medium mb-2 text-gray-800">Top Issues</h3>
        <ul class="list-disc pl-5 text-sm text-gray-600 space-y-1">
          <li>Screen Replacement</li>
          <li>Battery Issues</li>
          <li>Water Damage</li>
          <li>Software Problems</li>
        </ul>
      </div>
    </div>
  </div>
</main>
