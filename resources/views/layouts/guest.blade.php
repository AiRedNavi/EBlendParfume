<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>E-Blend Parfume | Autentikasi</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Plus+Jakarta+Sans:400,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FCF3EE; }
            /* Efek Kartun Pop-Up (Neo-Brutalism Shadow) */
            .cartoon-box {
                border: 3px solid #000000;
                box-shadow: 8px 8px 0px #000000;
            }
            .cartoon-button {
                border: 2px solid #000000;
                box-shadow: 4px 4px 0px #000000;
                transition: all 0.1s ease;
            }
            .cartoon-button:active {
                transform: translate(2px, 2px);
                box-shadow: 1px 1px 0px #000000;
            }
            .cartoon-input {
                border: 2px solid #000000;
                transition: all 0.2s ease;
            }
            .cartoon-input:focus {
                box-shadow: 3px 3px 0px #000000;
                border-color: #FF6BD0;
            }
        </style>
    </head>
    <body class="text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-10 sm:pt-0 px-4">
            
            <!-- Merek Utama: Diperbesar dan Dipertegas -->
            <div class="mb-8 text-center">
                <a href="/" class="text-4xl md:text-5xl font-extrabold tracking-tight text-black flex items-center justify-center gap-2">
                    E-BLEND <span style="color: #FF6BD0;">PARFUME</span>
                </a>
            </div>

            <!-- Kotak Form: Ditambahkan Inline Padding yang Kuat -->
            <div class="w-full sm:max-w-md bg-white rounded-2xl cartoon-box" style="padding: 2.5rem;">
                {{ $slot }}
            </div>
            
        </div>
    </body>
</html>