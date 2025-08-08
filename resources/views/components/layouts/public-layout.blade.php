<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaFix - Software Repair Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            600: '#1E40AF',
                            700: '#1E3A8A',
                        },
                        dark: {
                            800: '#1E293B',
                            900: '#0F172A'
                        },
                        accent: {
                            500: '#10B981',
                            600: '#059669'
                        }
                    },
                    animation: {
                        'float': 'float 4s ease-in-out infinite',
                        'pulse-slow': 'pulse 6s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'fade-in': 'fadeIn 1s ease-out',
                        'slide-up': 'slideUp 0.8s ease-out',
                        'glow': 'glow 2s ease-in-out infinite'
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-12px)' }
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        },
                        glow: {
                            '0%, 100%': { boxShadow: '0 0 5px rgba(16, 185, 129, 0.4)' },
                            '50%': { boxShadow: '0 0 20px rgba(16, 185, 129, 0.8)' }
                        }
                    }
                }
            }
        }
    </script>
    
    @livewireStyles
</head>

<body class="">


    <!-- Mobile Overlay -->

    <main class="flex-grow flex items-center justify-center py-12">
          {{ $slot }}
        
    </main>

    @livewireScripts
    
</body>

</html>