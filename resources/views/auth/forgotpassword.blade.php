@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen font-[Outfit,sans-serif] bg-gradient-to-br from-indigo-100 via-blue-50 to-violet-100">
    <div class="fixed inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-indigo-200/60 via-slate-100/40 to-blue-100/50"></div>
    <div class="fixed inset-0 -z-10 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.13]"></div>

    @include('components.navigation')

    <div class="flex-1 flex items-center justify-center">
        <div class="container mx-auto px-4 py-12">
            <div class="max-w-md mx-auto bg-white/60 backdrop-blur-2xl rounded-2xl shadow-xl border border-white/40 ring-1 ring-indigo-100 p-8 animate-fade-in">
                <div class="text-center mb-8">
                    <div class="flex justify-center">
                        <x-lucide-shopping-cart class="text-indigo-500 drop-shadow-lg" size="44" />
                    </div>
                    <h1 class="mt-4 text-3xl font-extrabold text-gray-800 tracking-tight drop-shadow-sm" style="font-family: 'Outfit', 'Montserrat', sans-serif;">
                        Forgot Password
                    </h1>
                    <p class="mt-2 text-gray-600">
                        Enter your email and we'll send you a reset link
                    </p>
                </div>

                @if(session('submitted'))
                    <div class="text-center animate-fade-in">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Check your email</h2>
                        <p class="text-gray-600 mb-6">
                            If an account exists for <span class="font-medium">{{ session('email') }}</span>, you will receive a password reset link shortly.
                        </p>
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-semibold transition-colors">Back to Sign In</a>
                    </div>
                @else
                    <form method="POST" action="{{ route('password.email') }}" class="animate-fade-in" novalidate>
                        @csrf

                        <div class="mb-4 text-left">
                            <label for="email" class="block text-gray-700 font-semibold mb-1">
                                Email
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="you@example.com"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-white/80 shadow-sm hover:shadow-md @error('email') border-red-500 @enderror"
                                required
                            />
                            @error('email')
                                <div class="bg-red-50 text-red-600 p-3 rounded-lg mt-2 animate-shake border border-red-200 shadow">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            class="w-full bg-gradient-to-r from-indigo-500 via-violet-500 to-blue-500 text-white py-2 px-4 rounded-xl shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-200 font-semibold border-2 border-transparent hover:border-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                        >
                            Send Reset Link
                        </button>
                    </form>
                @endif

                <div class="mt-6 text-center text-gray-600">
                    Remembered your password?{' '}
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-semibold transition-colors">
                        Sign in
                    </a>
                </div>

                <div class="mt-8 text-center text-gray-500 text-sm">
                    <a href="{{ route('privacy') }}" class="text-indigo-600 hover:underline font-semibold transition-colors">
                        Privacy Policy
                    </a>
                </div>
            </div>
        </div>
    </div>

    @include('components.footer')
</div>
@endsection