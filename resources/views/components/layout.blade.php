<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Qura — Live Queue Portal' }}</title>
    
    <!-- Google Fonts: Newsreader (Editorial Serif) & Plus Jakarta Sans / Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,opsz,wght@0,6..72,300;0,6..72,400;0,6..72,500;0,6..72,600;1,6..72,300;1,6..72,400;1,6..72,500&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;1,400;1,500&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['"Newsreader"', '"Playfair Display"', 'Georgia', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                    },
                    colors: {
                        cream: {
                            50: '#FDFCFB',
                            100: '#FAF8F5',
                            200: '#F5F2EC',
                            300: '#EFEAE1',
                            400: '#E5DFD3',
                        },
                        ink: {
                            900: '#141413',
                            800: '#1F1E1D',
                            700: '#2E2D2A',
                            600: '#4A4844',
                            500: '#6B6862',
                            400: '#949089',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FAF8F5;
            color: #1F1E1D;
            -webkit-font-smoothing: antialiased;
        }
        .font-editorial {
            font-family: 'Newsreader', Georgia, serif;
        }
    </style>
</head>
<body class="min-h-full flex flex-col bg-[#FAF8F5] text-ink-800 antialiased selection:bg-stone-900 selection:text-white">

    <!-- EDITORIAL NAVBAR -->
    <header class="w-full bg-[#FAF8F5]/90 backdrop-blur-sm border-b border-stone-200/70 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-8 h-20 flex items-center justify-between">
            
            <!-- LEFT: NAVIGATION LINKS -->
            <div class="flex items-center gap-6 text-xs uppercase tracking-widest font-semibold text-ink-600">
                <a href="{{ route('index') }}" class="hover:text-ink-900 transition-colors">
                    Departments
                </a>
                
                @auth
                    @if(Auth::user()->queue)
                        <a href="{{ route('queue.show') }}" class="inline-flex items-center gap-2 text-stone-900 font-bold hover:opacity-75 transition-opacity">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            <span>Ticket #{{ Auth::user()->queue->ticket_number }}</span>
                        </a>
                    @endif
                @endauth
            </div>

            <!-- CENTER: BESPOKE SERIF BRAND LOGO -->
            <a href="{{ route('index') }}" class="text-center group">
                <span class="font-editorial text-3xl sm:text-4xl text-ink-900 tracking-tight block group-hover:opacity-80 transition-opacity">
                    Qura
                </span>
            </a>

            <!-- RIGHT: MINIMAL AUTH ACTIONS -->
            <div class="flex items-center gap-4 sm:gap-6">
                @auth
                    <!-- Authenticated State -->
                    <div class="flex items-center gap-4">
                        <span class="text-xs text-ink-500 font-medium hidden sm:inline-block">
                            Welcome, <span class="text-ink-900 font-semibold">{{ Auth::user()->name ?: 'User' }}</span>
                        </span>

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" 
                                class="inline-flex items-center justify-center px-5 py-2.5 rounded-full text-xs font-semibold uppercase tracking-wider bg-ink-900 hover:bg-black text-white transition-all duration-200 cursor-pointer shadow-xs active:scale-95">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Guest State -->
                    <div class="flex items-center gap-4 sm:gap-6">
                        <a href="{{ route('login') }}" 
                            class="text-xs uppercase tracking-widest font-semibold text-ink-600 hover:text-ink-900 transition-colors">
                            Sign In
                        </a>

                        <a href="{{ route('register') }}" 
                            class="inline-flex items-center justify-center px-6 py-2.5 rounded-full text-xs font-semibold uppercase tracking-wider bg-ink-900 hover:bg-black text-white transition-all duration-200 cursor-pointer shadow-xs active:scale-95">
                            Register
                        </a>
                    </div>
                @endauth
            </div>

        </div>
    </header>

    <!-- FLASH ALERTS -->
    <div class="max-w-7xl mx-auto px-4 sm:px-8 w-full pt-4">
        @if(session('success'))
            <div class="mb-4 flex items-center justify-between px-5 py-3.5 rounded-2xl bg-white border border-stone-200 text-xs font-medium text-ink-800 shadow-xs">
                <div class="flex items-center gap-2.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-stone-400 hover:text-stone-700 text-sm leading-none p-1 cursor-pointer">
                    &times;
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 flex items-center justify-between px-5 py-3.5 rounded-2xl bg-white border border-rose-200 text-xs font-medium text-rose-800 shadow-xs">
                <div class="flex items-center gap-2.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-400 hover:text-rose-700 text-sm leading-none p-1 cursor-pointer">
                    &times;
                </button>
            </div>
        @endif
    </div>

    <!-- MAIN PAGE CONTENT -->
    <main class="flex-1 w-full">
        {{ $slot }}
    </main>

    <!-- EDITORIAL MINIMAL FOOTER -->
    <footer class="mt-auto w-full border-t border-stone-200/70 bg-[#FAF8F5] py-10 px-4 sm:px-8">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-6 text-xs text-ink-500">
            <div class="flex items-center gap-4">
                <span class="font-editorial text-lg text-ink-900">Qura</span>
                <span class="text-stone-300">•</span>
                <span class="tracking-wide">Clinical Outpatient Queue Management</span>
            </div>
            <div class="flex items-center gap-6 text-xs uppercase tracking-widest text-ink-500 font-medium">
                <a href="{{ route('index') }}" class="hover:text-ink-900 transition-colors">Departments</a>
                <span>•</span>
                <span>Privacy & Care</span>
                <span>•</span>
                <span>Live Triage</span>
            </div>
        </div>
    </footer>

</body>
</html>