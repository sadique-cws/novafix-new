<!DOCTYPE html>
<html lang="en" class="font-poppins">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>TechCare - Service Center Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            poppins: ['Poppins', 'sans-serif'],
          },
          colors: {
            primary: '#3B82F6',      // indigo-500
            secondary: '#10B981',    // emerald-500
            danger: '#EF4444',       // red-500
            warning: '#F59E0B',      // amber-500
            info: '#06B6D4',         // cyan-500
          }
        }
      }
    };
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-800 font-poppins">
  <!-- Fixed Navbar -->
  <header class="fixed top-0 left-0 right-0 bg-white shadow-md z-50">
    <div class="px-4 py-3 flex justify-between items-center">
      <div class="flex items-center gap-3">
        <button id="mobile-menu-button" class="md:hidden text-gray-600 hover:text-gray-900">
          <i class="fas fa-bars text-xl"></i>
        </button>
        <img src="https://placehold.co/40x40" alt="TechCare logo" class="h-10 w-10 rounded-full border-2 border-primary">
        <h1 class="text-xl md:text-2xl font-semibold text-gray-800">TechCare Service Center</h1>
      </div>
      <div class="flex items-center space-x-4">
        <button class="relative p-2 text-gray-600 hover:text-gray-900 focus:outline-none">
          <i class="fas fa-bell text-xl"></i>
          <span class="absolute -top-1 -right-1 px-1.5 py-0.5 text-xs font-bold text-white bg-red-500 rounded-full">3</span>
        </button>
        <div class="flex items-center gap-2">
          <img src="https://placehold.co/36x36" alt="Admin Profile" class="h-9 w-9 rounded-full border-2 border-primary">
          <span class="font-medium hidden sm:inline">John Doe</span>
        </div>
      </div>
    </div>
  </header>

  <div class="flex pt-[72px]">
    <!-- Fixed Sidebar (desktop) -->
    <aside id="sidebar" class="fixed md:relative z-40 bg-white w-64 shadow-md py-6 inset-y-0 left-0 transform -translate-x-full md:translate-x-0 transition duration-200 ease-in-out">
      <nav>
        <ul class="space-y-1">
          <li>
            <a href="#" class="flex items-center px-5 py-3 bg-primary text-white font-medium rounded-r-full">
              <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
            </a>
          </li>
          <li>
            <a href="{{ route('frontdesk.servicerequest.create') }}" class="flex items-center px-5 py-3 hover:bg-gray-100 text-gray-700 rounded-r-full transition duration-150">
              <i class="fas fa-plus-circle mr-3"></i> New Service
            </a>
          </li>
          <li>
            <a href="{{ route('frontdesk.servicerequest.manage') }}" class="flex items-center px-5 py-3 hover:bg-gray-100 text-gray-700 rounded-r-full transition duration-150">
              <i class="fas fa-tasks mr-3"></i> Service Queue
            </a>
          </li>
          <!-- ... other menu items ... -->
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-0 p-4 md:p-6">
      {{ $slot }}
    </main>
  </div>

  <!-- Mobile Overlay -->
  <div id="mobile-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden"></div>

  <!-- JS for Sidebar Toggle -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const mobileMenuButton = document.getElementById('mobile-menu-button');
      const sidebar = document.getElementById('sidebar');
      const mobileOverlay = document.getElementById('mobile-overlay');

      mobileMenuButton.addEventListener('click', function () {
        sidebar.classList.toggle('-translate-x-full');
        mobileOverlay.classList.toggle('hidden');
        document.body.classList.toggle('overflow-hidden');
      });

      mobileOverlay.addEventListener('click', function () {
        sidebar.classList.add('-translate-x-full');
        mobileOverlay.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
      });

      document.querySelectorAll('#sidebar nav ul li a').forEach(item => {
        item.addEventListener('click', function () {
          if (window.innerWidth < 768) {
            sidebar.classList.add('-translate-x-full');
            mobileOverlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
          }
        });
      });

      window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
          sidebar.classList.remove('-translate-x-full');
          mobileOverlay.classList.add('hidden');
          document.body.classList.remove('overflow-hidden');
        }
      });
    });
  </script>
</body>
</html>
