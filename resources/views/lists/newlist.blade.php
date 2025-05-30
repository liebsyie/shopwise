@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen font-[Outfit,sans-serif] bg-gradient-to-br from-indigo-100 via-blue-50 to-violet-100">
    <div class="fixed inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-indigo-200/60 via-slate-100/40 to-blue-100/50"></div>
    <div class="fixed inset-0 -z-10 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.13]"></div>

    <div class="flex-1 flex items-center justify-center">
        <div class="container mx-auto px-4 py-12">
            <div class="max-w-xl mx-auto bg-white/60 backdrop-blur-2xl rounded-2xl shadow-xl border border-white/40 ring-1 ring-indigo-100 p-8 animate-fade-in">
                <div class="flex items-center gap-3 mb-8 justify-center">
                    {{-- Replace with your preferred icon --}}
                    <svg class="text-indigo-500 drop-shadow-lg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="32" height="32"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4m0 0v6a2 2 0 002 2h4a2 2 0 002-2v-6m-6 0h6"/></svg>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800 tracking-tight drop-shadow-sm" style="font-family: 'Outfit', 'Montserrat', sans-serif;">
                        Create New Shopping List
                    </h1>
                </div>

                <form method="POST" action="{{ route('newlist.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 font-semibold mb-1">List Name</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            placeholder="Weekly Groceries"
                            value="{{ old('name') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-white/80 shadow-sm hover:shadow-md @error('name') border-red-500 @enderror"
                        />
                        @error('name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="budget" class="block text-gray-700 font-semibold mb-1">Budget</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <span class="text-gray-500">₱</span>
                            </div>
                            <input
                                type="number"
                                name="budget"
                                id="budget"
                                placeholder="100.00"
                                step="0.01"
                                min="0"
                                value="{{ old('budget') }}"
                                class="w-full pl-8 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-white/80 shadow-sm hover:shadow-md @error('budget') border-red-500 @enderror"
                            />
                        </div>
                        @error('budget')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="description" class="block text-gray-700 font-medium mb-2">Description (Optional)</label>
                        <textarea
                            name="description"
                            id="description"
                            rows="3"
                            placeholder="Add notes about this shopping list"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 outline-none transition bg-white/80 shadow-sm hover:shadow-md"
                        >{{ old('description') }}</textarea>
                    </div>

                    <div class="flex gap-4">
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Cancel</a>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-gradient-to-r from-indigo-500 via-violet-500 to-blue-500 text-white rounded-xl shadow-lg hover:scale-105 hover:shadow-xl transition-all duration-200 font-semibold border-2 border-transparent hover:border-indigo-300 focus:outline-none focus:ring-2 focus:ring-indigo-400 flex-1"
                        >
                            Create List
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection