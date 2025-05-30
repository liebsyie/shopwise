@extends('layouts.app')

@section('title', 'Register - ShopWise')

@section('content')
<!-- Google Fonts -->
@push('styles')
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet">
@endpush

<div class="flex flex-col min-h-screen font-[Outfit,sans-serif] bg-gradient-to-br from-indigo-100 via-blue-50 to-violet-100">
  <!-- Background Gradients -->
  <div class="fixed inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-indigo-200/60 via-slate-100/40 to-blue-100/50"></div>
  <div class="fixed inset-0 -z-10 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.13]"></div>

  @include('partials.navigation')

  <div class="flex-1 flex items-center justify-center">
    <div class="container mx-auto px-4 py-12">
      <div class="max-w-md mx-auto bg-white/60 backdrop-blur-2xl rounded-2xl shadow-xl border border-white/40 ring-1 ring-indigo-100 p-8">
        <!-- Header -->
        <div class="text-center mb-8">
          <div class="flex justify-center">
            <x-lucide-shopping-cart class="text-indigo-500 drop-shadow-lg" size="44" />
          </div>
          <h1 class="mt-4 text-3xl font-extrabold text-gray-800 tracking-tight drop-shadow-sm" style="font-family: 'Outfit', 'Montserrat', sans-serif;">
            Create your account
          </h1>
          <p class="mt-2 text-gray-600">
            Join ShopWise to manage your shopping budget
          </p>
        </div>

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}" class="space-y-6">
          @csrf
          <!-- Name -->
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" id="name" required autofocus
              value="{{ old('name') }}"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('name')
              <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
          </div>

          <!-- Email -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
            <input type="email" name="email" id="email" required
              value="{{ old('email') }}"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('email')
              <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
          </div>

          <!-- Password -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" required
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('password')
              <span class="text-sm text-red-500">{{ $message }}</span>
            @enderror
          </div>

          <!-- Confirm Password -->
          <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
          </div>

          <!-- Submit -->
          <div>
            <button type="submit"
              class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition">
              Create Account
            </button>
          </div>
        </form>

        <!-- Login Redirect -->
        <div class="mt-6 text-center text-gray-600">
          Already have an account?
          <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-semibold transition-colors">
            Sign in
          </a>
        </div>
      </div>
    </div>
  </div>

  @include('partials.footer')
</div>
@endsection