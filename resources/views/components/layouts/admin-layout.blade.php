<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body>
     <livewire:partials.navbar />

    <!-- Main layout -->
    <div class="flex mt-16">
        <!-- Sidebar -->
        <div class="w-3/12">
            <livewire:partials.sidebar />
        </div>

        <!-- Page content -->
        <div class="w-9/12">
            <div class="bg-white shadow-md rounded-lg p-6">
                {{ $slot }}
            </div>
        </div>
    </div>

    @livewireScripts
    
</body>
</html>
