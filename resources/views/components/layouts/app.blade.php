<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name', 'Novafix') }}</title>
        <script src="https://cdn.tailwindcss.com"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles

         <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        header {
            background: #f4f4f4;
            text-align: center;
            padding: 10px;
        }
        nav {
            margin: 10px 0;
        }
        nav a {
            margin: 0 15px;
            text-decoration: none;
            color: #333;
        }
        .hero {
            background: #ff6200;
            color: white;
            text-align: center;
            padding: 50px 20px;
        }
        .services {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
        }
        .service-item {
            background: #f9e7e7;
            margin: 10px;
            padding: 20px;
            text-align: center;
            width: 200px;
        }
        .experience, .benefits, .training {
            padding: 20px;
            text-align: center;
        }
        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .benefit-item {
            background: #e0f7fa;
            padding: 20px;
        }
        footer {
            background: #f4f4f4;
            text-align: center;
            padding: 10px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        @media (max-width: 600px) {
            .services {
                flex-direction: column;
                align-items: center;
            }
            .service-item {
                width: 80%;
            }
        }
    </style>
    </head>
    <body class="font-sans antialiased">
        
 <header>
        <img src="novafix-logo.png" alt="NovaFix Logo" style="height: 50px;"
            onerror="this.onerror=null;this.src='https://placehold.co/150x50?text=NovaFix+Logo';">
        <nav>
            <a href="#contact">Contact</a>
            <a href="#learn">Learn</a>
            <a href="#track-status">Track Status</a>
            <a href="#request-repair">Request Repair</a>
        </nav>
    </header>
        <main>
            {{ $slot }}
        </main>

<footer>
        <p>NovaFix | +91 7885802002 | NovaFix@gmail.com</p>
        <p>2nd Floor, Near 80ft Road, Pune (India) | 411030</p>
        <p><a href="#warranty-policy">Warranty Policy</a> | <a href="#terms">Terms</a> | <a href="#our-team">Our Team</a></p>
        <p>Copyright © All rights reserved.</p>
    </footer>

    
</body>
</html>
        @livewireScripts
    </body>
</html>
