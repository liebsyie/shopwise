@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen font-[Outfit,sans-serif] bg-gradient-to-br from-indigo-100 via-blue-50 to-violet-100">
  <div class="fixed inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-indigo-200/60 via-slate-100/40 to-blue-100/50"></div>
  <div class="fixed inset-0 -z-10 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.13]"></div>

  @include('components.navigation')

  <div class="flex-1">
    <div class="container mx-auto px-4 py-8">
      <div class="flex items-center mb-6">
        <a href="{{ url()->previous() }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition font-semibold p-0 mr-2 bg-transparent border-none shadow-none" style="box-shadow: none; background: none;">
          <x-icon-arrow-left class="w-5 h-5" />
        </a>
        <h1 class="text-2xl font-bold text-indigo-600 hover:text-indigo-800 transition font-semibold" style="font-family: 'Outfit', 'Montserrat', sans-serif;">
          My Profile
        </h1>
      </div>

      <div class="bg-white/60 backdrop-blur-2xl rounded-2xl shadow-xl p-8 border border-white/40 ring-1 ring-indigo-100 max-w-2xl mx-auto relative animate-fade-in">

        @if(session('message'))
          <div class="fixed top-8 left-1/2 z-50 -translate-x-1/2 px-6 py-3 rounded-xl shadow-lg text-base font-semibold
            {{ session('message_type') == 'success' ? 'bg-green-500 text-white' : 'bg-blue-600 text-white' }}">
            {{ session('message') }}
          </div>
        @endif

        <div class="flex flex-col items-center mb-6">
          <div class="relative mb-4">
            <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
              @if(auth()->user()->photo_url)
                <img src="{{ auth()->user()->photo_url }}" alt="Profile" class="w-full h-full object-cover" />
              @else
                <x-icon-user class="text-gray-400 w-10 h-10" />
              @endif
            </div>
            @if($editing ?? false)
              <label class="absolute bottom-0 right-0 bg-indigo-600 text-white p-2 rounded-full cursor-pointer hover:bg-indigo-700 transition">
                <x-icon-camera class="w-4 h-4" />
                <input type="file" name="profile_image" form="profileForm" accept="image/*" class="hidden" />
              </label>
            @endif
          </div>

          <h2 class="text-xl font-semibold text-gray-800 mb-2">
            {{ old('nickname', auth()->user()->name ?? 'No name set') }}
          </h2>

          @if(!($editing ?? false))
            <form method="POST" action="{{ route('profile.edit.toggle') }}">
              @csrf
              <button type="submit" class="text-indigo-600 hover:underline mb-4 font-semibold transition-colors">
                Edit Profile
              </button>
            </form>
          @endif

          @if($errors->any())
            <div class="mb-4 p-3 rounded-lg text-sm bg-red-100 text-red-800">
              {{ $errors->first() }}
            </div>
          @endif

          @if($editing ?? false)
            <form method="POST" action="{{ route('profile.update') }}" id="profileForm" enctype="multipart/form-data" class="w-full">
              @csrf
              @method('PUT')

              <div class="mb-4">
                <label for="nickname" class="block text-gray-700 text-sm font-medium mb-2">Nickname</label>
                <input
                  type="text"
                  id="nickname"
                  name="nickname"
                  value="{{ old('nickname', auth()->user()->name) }}"
                  class="w-full p-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:border-transparent bg-white/80 shadow-sm hover:shadow-md"
                  placeholder="Enter your nickname"
                  required
                />
              </div>

              <button type="submit" class="w-full bg-gradient-to-r from-indigo-500 via-violet-500 to-blue-500 text-white py-3 rounded-xl shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-200 font-semibold border-2 border-transparent hover:border-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                Save Changes
              </button>
            </form>
          @endif
        </div>

        <div class="bg-indigo-50/60 rounded-xl p-4 mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
          <div>
            <div class="text-gray-700 text-sm font-medium">Account Created</div>
            <div class="text-lg font-semibold text-indigo-700">
              {{ auth()->user()->created_at ? auth()->user()->created_at->format('F j, Y') : 'N/A' }}
            </div>
          </div>
          <div>
            <div class="text-gray-700 text-sm font-medium">Last Login</div>
            <div class="text-lg font-semibold text-indigo-700">
              {{ auth()->user()->last_login ? auth()->user()->last_login->format('F j, Y, h:i A') : 'N/A' }}
            </div>
          </div>
        </div>

        <div class="mb-6">
          <form method="POST" action="{{ route('profile.download') }}">
            @csrf
            <button
              type="submit"
              class="w-full bg-gradient-to-r from-indigo-500 via-violet-500 to-blue-500 text-white py-3 rounded-xl shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-200 font-semibold border-2 border-transparent hover:border-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 flex items-center justify-center gap-2"
            >
              <x-icon-download class="w-5 h-5" />
              Download My Data
            </button>
          </form>
        </div>

        <div class="border-t border-gray-200 pt-4">
          <h3 class="text-lg font-semibold text-gray-800 mb-3">Account Settings</h3>
          <div class="relative">
            <form method="POST" action="{{ route('profile.delete') }}" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
              @csrf
              @method('DELETE')
              <button
                type="submit"
                class="w-full bg-red-600 text-white py-3 rounded-lg hover:bg-red-700 transition flex items-center justify-center font-semibold"
              >
                <x-icon-trash class="mr-2 w-5 h-5" />
                Delete Account
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('components.footer')
</div>
@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Montserrat:wght@700;800&display=swap" rel="stylesheet" />
<style>
.animate-fade-in { animation: fadeIn 0.3s; }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
</style>
@endpush