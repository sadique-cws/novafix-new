<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaFix - Software Repair Center</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --color-primary-600: #1E40AF;
            --color-primary-700: #1E3A8A;
            --color-dark-800: #1E293B;
            --color-dark-900: #0F172A;
            --color-accent-500: #10B981;
            --color-accent-600: #059669;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
        @keyframes slideUp {
            0% { transform: translateY(20px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }
        @keyframes glow {
            0%, 100% { box-shadow: 0 0 5px rgba(16, 185, 129, 0.4); }
            50% { box-shadow: 0 0 20px rgba(16, 185, 129, 0.8); }
        }

        .animate-float { animation: float 4s ease-in-out infinite; }
        .animate-pulse-slow { animation: pulse 6s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        .animate-fade-in { animation: fadeIn 1s ease-out; }
        .animate-slide-up { animation: slideUp 0.8s ease-out; }
        .animate-glow { animation: glow 2s ease-in-out infinite; }
    </style>
    
    @livewireStyles
</head>

<body class="">


    <!-- Mobile Overlay -->

    <main class="flex-grow flex items-center justify-center py-12">
          {{ $slot }}
        
    </main>

    @livewireScripts
    
</body>

</html>herman.ruecker@example.org