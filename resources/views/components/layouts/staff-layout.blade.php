<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novafix | Staff</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1E40AF',
                        secondary: '#3B82F6',
                        success: '#10b981',
                        warning: '#f59e0b',
                        danger: '#ef4444',
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #F9FAFB;
            color: #111827;
        }
    </style>
</head>

<body class="bg-gray-50" x-data="dashboard()">
    <!-- Mobile backdrop -->
    <div x-show="isMobileSidebarOpen" @click="isMobileSidebarOpen = false"
        class="fixed inset-0 bg-black bg-opacity-40 z-40 lg:hidden transition-opacity duration-300"
        :class="isMobileSidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'">
    </div>

    <div class="flex gap-1">
        <!-- Sidebar -->
        <div class="fixed top-0 left-0 h-screen w-64 bg-white border-r border-gray-200 z-50 transform transition-transform duration-300"
            :class="isMobileSidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

            <!-- Sidebar Header -->
            <div class="pt-4 pb-3 px-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="py-1 px-3 rounded bg-primary text-white text-base">NF</div>
                    <h2 class="text-base md:text-lg text-gray-800">Staff Panel</h2>
                </div>
                <button @click="isMobileSidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="p-3">
                <ul class="space-y-1">
                    <li>
                        <a wire:navigate href="{{ route('staff.dashboard') }}"
                            class="flex items-center px-3 py-2 rounded hover:bg-gray-50 text-gray-700">
                            <i class="fas fa-tachometer-alt w-5 text-primary"></i>
                            <span class="ml-2">Dashboard</span>
                        </a>
                    </li>
                     <li>
                        <a wire:navigate href="{{ route('staff.novafix-diagnosis') }}"
                            class="flex items-center px-3 py-2 rounded hover:bg-gray-50 text-gray-700">
                            <i class="fas fa-tachometer-alt w-5 text-primary"></i>
                            <span class="ml-2">Solution</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('staff.assigned.task') }}"
                            class="flex items-center px-3 py-2 rounded bg-primary/10 text-primary">
                            <i class="fas fa-tasks w-5"></i>
                            <span class="ml-2">Assigned Tasks</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('staff.completed.task') }}"
                            class="flex items-center px-3 py-2 rounded hover:bg-gray-50 text-gray-700">
                            <i class="fas fa-check-circle w-5 text-accent"></i>
                            <span class="ml-2">Completed Tasks</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Sidebar Profile -->
            <div class="p-4 border-t flex items-center gap-3">
                <img src="https://e7.pngegg.com/pngimages/16/412/png-clipart-computer-icons-encapsulated-postscript-staff-miscellaneous-black-thumbnail.png"
                    alt="User" class="w-10 h-10 rounded-full border">
                <div>
                    <p class="text-gray-800">Staff Profile</p>
                    <a wire:navigate href="{{ route('staff.profile') }}"
                        class="text-xs text-secondary hover:underline">View Profile</a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="min-h-screen w-full md:w-[calc(100%-16rem)] md:ml-64">
            <!-- Mobile Topbar -->
            <div class="lg:hidden flex items-center justify-between px-4 py-3 bg-white border-b">
                <button @click="isMobileSidebarOpen = true" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <div class="flex items-center gap-3">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2">
                            <img src="https://e7.pngegg.com/pngimages/16/412/png-clipart-computer-icons-encapsulated-postscript-staff-miscellaneous-black-thumbnail.png"
                                alt="User profile" class="rounded-full w-8 h-8 object-cover border">
                            <i class="fas fa-chevron-down text-xs text-gray-500" :class="open ? 'rotate-180' : ''"></i>
                        </button>

                        <div x-show="open" @click.outside="open = false" x-transition
                            class="absolute right-0 mt-2 w-48 bg-white rounded border border-gray-200 py-1 z-20">
                            <a href="{{ route('staff.profile') }}"
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                            <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Settings</a>
                            <div class="border-t"></div>
                            <a href="#" class="block px-4 py-2 text-red-600 hover:bg-red-50">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Slot -->
            <main class="p-2">

                {{ $slot }}

            </main>
        </div>
    </div>

    <script>
        function dashboard() {
            return {
                isMobileSidebarOpen: false,
            }
        }
    </script>
</body>

</html>
