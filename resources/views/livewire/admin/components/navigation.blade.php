<div class="md:grid md:block hidden md:grid-cols-7 gap-2  mx-auto">
    <x-nav-link :href="route('admin.solution.staff-diagnosis')"
        :active="request()->routeIs('admin.solution.staff-diagnosis')" wire:navigate>
        {{ __('Novafix Diagnosis') }}
    </x-nav-link>
    <x-nav-link :href="route('admin.solution')" :active="request()->routeIs('admin.solution')" wire:navigate>
        {{ __('Admin Panel') }}
    </x-nav-link>
    <x-nav-link :href="route('admin.solution.manage-devices')"
        :active="request()->routeIs('admin.solution.manage-devices')" wire:navigate>
        {{ __('Devices') }}
    </x-nav-link>
    <x-nav-link :href="route('admin.solution.manage-brands')"
        :active="request()->routeIs('admin.solution.manage-brands')" wire:navigate>
        {{ __('Brands') }}
    </x-nav-link>
     <x-nav-link :href="route('admin.solution.manage-models')" :active="request()->routeIs('admin.solution.manage-models')" wire:navigate>
            {{ __('Models') }}
        </x-nav-link>
     <x-nav-link :href="route('admin.solution.manage-problems')" :active="request()->routeIs('admin.solution.manage-problems')" wire:navigate>
            {{ __('Problems') }}
        </x-nav-link>
    <div class="p-1 border bg-gray-200 flex items-center justify-center font-medium rounded">
        <h2 class="text-lg">User Answers</h2>
    </div>
</div>