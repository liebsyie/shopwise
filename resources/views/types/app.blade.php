<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ShopWise')</title>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CSS (assuming you're using Laravel Mix or Vite) --}}
    @vite('resources/css/app.css')

    @stack('styles')
</head>
<body class="flex flex-col min-h-screen font-[Outfit,sans-serif] bg-gradient-to-br from-indigo-100 via-blue-50 to-violet-100 relative">

    {{-- Radial background gradient --}}
    <div class="fixed inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-indigo-200/60 via-slate-100/40 to-blue-100/50"></div>

    {{-- Grainy noise overlay --}}
    <div class="fixed inset-0 -z-10 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.13]"></div>

    {{-- Navigation --}}
    @include('partials.navigation')

    {{-- Flash message (toast-style) --}}
    @if (session('status'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
             class="fixed top-5 right-5 z-50 bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-lg">
            {{ session('status') }}
        </div>
    @endif

    {{-- Page Content --}}
    <main class="flex-1 flex items-center justify-center">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    {{-- Alpine.js for flash message animation --}}
    <script src="//unpkg.com/alpinejs" defer></script>

    @stack('scripts')
</body>
</html>