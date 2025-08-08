<div class="container mx-auto px-4 py-8 max-w-5xl">
  <div class="bg-white rounded-xl shadow-lg p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
      <h2 class="text-3xl font-extrabold text-gray-900">Receptionist Details</h2>
      <a wire:navigate href="{{ route('franchise.manage.receptioners') }}"
         class="mt-4 md:mt-0 inline-block px-6 py-3 bg-gray-700 text-white rounded-lg font-semibold shadow-md hover:bg-gray-800 transition duration-300">
        ← Back to List
      </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <!-- Personal Information -->
      <section class="bg-gray-50 rounded-lg p-6 shadow-sm">
        <h3 class="text-xl font-semibold text-gray-800 mb-6 border-b border-gray-300 pb-3">Personal Information</h3>
        <dl class="space-y-5 text-gray-700">
          <div>
            <dt class="text-sm font-medium text-gray-500">Name</dt>
            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $receptionist->name }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Email</dt>
            <dd class="mt-1 text-lg text-gray-800 truncate">{{ $receptionist->email }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Contact</dt>
            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $receptionist->contact }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Aadhar Number</dt>
            <dd class="mt-1 text-lg text-gray-800 tracking-widest">{{ $receptionist->aadhar }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">PAN Number</dt>
            <dd class="mt-1 text-lg text-gray-800 uppercase tracking-wide">{{ $receptionist->pan }}</dd>
          </div>
        </dl>
      </section>

      <!-- Employment Details -->
      <section class="bg-gray-50 rounded-lg p-6 shadow-sm">
        <h3 class="text-xl font-semibold text-gray-800 mb-6 border-b border-gray-300 pb-3">Employment Details</h3>
        <dl class="space-y-5 text-gray-700">
          <div>
            <dt class="text-sm font-medium text-gray-500">Salary</dt>
            <dd class="mt-1 text-lg font-semibold text-indigo-700">₹{{ number_format($receptionist->salary, 2) }}</dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Status</dt>
            <dd>
              <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                {{ $receptionist->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $receptionist->status ? 'Active' : 'Inactive' }}
              </span>
            </dd>
          </div>
          <div>
            <dt class="text-sm font-medium text-gray-500">Joined On</dt>
            <dd class="mt-1 text-lg text-gray-900 font-medium">{{ $receptionist->created_at->format('d M Y') }}</dd>
          </div>
        </dl>
      </section>

      <!-- Address -->
      <section class="bg-gray-50 rounded-lg p-6 shadow-sm md:col-span-2">
        <h3 class="text-xl font-semibold text-gray-800 mb-6 border-b border-gray-300 pb-3">Address</h3>
        <p class="text-gray-800 whitespace-pre-line text-lg leading-relaxed">{{ $receptionist->address }}</p>
      </section>
    </div>

    <div class="mt-10 flex flex-col sm:flex-row justify-end gap-4">
      <a wire:navigate href=""
         class="w-full sm:w-auto px-6 py-3 text-center bg-indigo-600 text-white rounded-lg font-semibold shadow-md 
                hover:bg-indigo-700 transition duration-300">
        Edit
      </a>
      <button wire:click="confirmDelete({{ $receptionist->id }})" type="button"
              class="w-full sm:w-auto px-6 py-3 text-center bg-red-600 text-white rounded-lg font-semibold shadow-md 
                hover:bg-red-700 transition duration-300">
        Delete
      </button>
    </div>
  </div>
</div>
