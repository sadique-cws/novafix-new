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
   <div class="p-4 bg-blue-500">
  <h2 class="font-semibold text-white text-2xl">   NovaFix</h2>
   </div>

   
    <div class="mt-24">
            
      {{ $slot }}
      
    </div>
    @livewireScripts
</body>
</html>
