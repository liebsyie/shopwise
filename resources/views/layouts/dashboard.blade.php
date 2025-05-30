@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8 gap-4">
        <h1 class="text-3xl font-extrabold tracking-tight text-indigo-600">My Shopping Lists</h1>
        <a href="{{ route('lists.create') }}" class="btn btn-primary flex items-center gap-2">
            <x-icons.plus /> New List
        </a>
    </div>

    @if($lists->isEmpty())
        <div class="text-center bg-white/60 p-10 rounded-2xl shadow-xl">
            <x-icons.shopping-bag class="mx-auto text-indigo-400 mb-4" size="56" />
            <h2 class="text-2xl font-bold text-gray-700 mb-2">No shopping lists yet</h2>
            <p class="text-gray-500 mb-6">Create your first shopping list to start tracking your grocery budget</p>
            <a href="{{ route('lists.create') }}" class="btn btn-primary inline-flex items-center gap-2">
                <x-icons.plus size="20" /> Create Shopping List
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($lists as $list)
                <div class="bg-white/60 rounded-2xl shadow-xl p-7 border border-white/40 ring-1 ring-indigo-100">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $list->name }}</h3>
                    <div class="flex items-center gap-2 text-gray-500 text-sm mb-4">
                        <x-icons.calendar size="16" />
                        <span>{{ $list->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="mb-4">
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Budget: ₱{{ number_format($list->budget, 2) }}</span>
                            <span class="font-medium">₱{{ number_format($list->total, 2) }} ({{ $list->percentage }}%)</span>
                        </div>
                        <div class="w-full bg-gray-200/60 rounded-full h-2.5">
                            <div
                                class="h-2.5 rounded-full transition-all duration-300
                                    @if ($list->budgetStatus['color'] === 'green')
                                        bg-gradient-to-r from-green-400 to-green-600
                                    @elseif ($list->budgetStatus['color'] === 'yellow')
                                        bg-gradient-to-r from-yellow-400 to-yellow-600
                                    @else
                                        bg-gradient-to-r from-red-400 to-red-600
                                    @endif"
                                style="width: {{ $list->percentage }}%;"
                            ></div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center mt-4">
                        <div class="text-gray-500 text-sm">{{ $list->items->count() }} items</div>
                        <a href="{{ route('lists.show', $list) }}" class="btn btn-outline btn-sm">View Details</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection