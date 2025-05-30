@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-100 via-blue-50 to-violet-100 p-6 font-sans">
    <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center mb-4">
        <!-- Use any back arrow icon or text -->
        &larr; Back to Dashboard
    </a>

    <div class="flex flex-col md:flex-row gap-6">
        <div class="md:w-8/12 bg-white/60 backdrop-blur-2xl rounded-2xl shadow-xl p-6 border border-white/40">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">{{ $list->name }}</h1>
                <div class="flex gap-2">
                    <a href="{{ url('/edit-list/'.$list->id) }}" class="bg-yellow-100 text-yellow-800 px-3 py-1.5 rounded-lg hover:bg-yellow-200 flex items-center gap-1 text-sm">
                        <!-- Pencil icon SVG here if you want -->
                        Edit
                    </a>
                    <form action="{{ route('lists.delete', $list->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this list?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-400 hover:text-red-500">
                            <!-- Trash icon SVG here if you want -->
                            Delete
                        </button>
                    </form>
                </div>
            </div>

            <div class="mb-6">
                @php
                    $remaining = $list->budget - $totalSpent;
                    $percentSpent = $list->budget > 0 ? ($totalSpent / $list->budget) * 100 : 0;

                    if ($percentSpent >= 100) {
                        $color = 'bg-red-500'; $textColor = 'text-red-600'; $message = 'Over Budget!';
                    } elseif ($percentSpent >= 90) {
                        $color = 'bg-orange-500'; $textColor = 'text-orange-600'; $message = 'Almost at limit!';
                    } elseif ($percentSpent >= 75) {
                        $color = 'bg-yellow-500'; $textColor = 'text-yellow-600'; $message = 'Approaching limit';
                    } else {
                        $color = 'bg-green-500'; $textColor = 'text-green-600'; $message = 'On Track';
                    }
                @endphp

                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Budget: ₱{{ number_format($list->budget, 2) }}</span>
                    <span class="font-medium {{ $remaining < 0 ? 'text-red-600' : 'text-green-600' }}">₱{{ number_format($remaining, 2) }} remaining</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 mb-1">
                    <div class="{{ $color }} h-2.5 rounded-full" style="width: {{ min($percentSpent, 100) }}%"></div>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">₱{{ number_format($totalSpent, 2) }} spent</span>
                    <span class="{{ $textColor }} font-medium">{{ $message }}</span>
                </div>
            </div>

            @if ($list->items->isEmpty())
                <div class="text-center py-8 text-gray-600">
                    <p>Your list is empty. Start adding items to your shopping list.</p>
                    <button onclick="document.getElementById('add-item-form').classList.toggle('hidden')" 
                        class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Add First Item
                    </button>
                </div>
            @else
                <div class="flex justify-between items-center mb-4">
                    <label for="categoryFilter" class="text-sm text-gray-600 mr-2">Filter by:</label>
                    <select id="categoryFilter" onchange="filterCategory(this.value)" class="px-2 py-1 border rounded text-sm">
                        <option value="all">All Categories</option>
                        @foreach($list->items->pluck('category_id')->unique() as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    </select>

                    <button onclick="document.getElementById('add-item-form').classList.toggle('hidden')" 
                        class="px-3 py-1.5 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm flex items-center gap-1">
                        <!-- Plus icon SVG -->
                        Add Item
                    </button>
                </div>

                <div class="overflow-x-auto border border-gray-200 rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                            <tr>
                                <th class="px-6 py-3 text-left">Item</th>
                                <th class="px-6 py-3 text-right">Price</th>
                                <th class="px-6 py-3 text-right">Quantity</th>
                                <th class="px-6 py-3 text-right">Total</th>
                                <th class="px-6 py-3">Checked</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="itemsTableBody" class="divide-y divide-gray-100 text-sm">
                            @foreach ($list->items as $item)
                            <tr data-category="{{ $item->category_id }}">
                                <td class="px-6 py-2">
                                    <a href="{{ url('/edit-item/'.$item->id) }}" class="text-indigo-600 hover:text-indigo-800">
                                        {{ $item->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-2 text-right">₱{{ number_format($item->price, 2) }}</td>
                                <td class="px-6 py-2 text-right">{{ $item->quantity }}</td>
                                <td class="px-6 py-2 text-right font-semibold">₱{{ number_format($item->price * $item->quantity, 2) }}</td>
                                <td class="px-6 py-2 text-center">
                                    <form method="POST" action="{{ route('lists.items.toggle', [$list->id, $item->id]) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-xl">
                                            {!! $item->checked ? '&#10003;' /* checkmark */ : '&#10007;' /* cross */ !!}
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-2 text-right">
                                    <form method="POST" action="{{ route('lists.items.delete', [$list->id, $item->id]) }}" onsubmit="return confirm('Remove this item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <!-- Trash icon SVG -->
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="md:w-4/12 bg-white/60 backdrop-blur-2xl rounded-2xl shadow-xl p-6 border border-white/40">
            <h2 class="font-bold mb-4">Add Grocery Item</h2>

            <form id="add-item-form" action="{{ route('lists.items.add', $list->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Item Name</label>
                    <input type="text" name="name" id="name" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" name="price" id="price" min="0" step="0.01" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" name="quantity" id="quantity" min="1" value="1" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                    <input type="text" name="category_id" id="category_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="checked" id="checked" class="mr-2">
                    <label for="checked" class="text-sm text-gray-700">Checked</label>
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Add Item</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="fixed bottom-5 right-5 bg-green-600 text-white py-2 px-4 rounded shadow">
            {{ session('success') }}
        </div>
    @endif
</div>

<script>
function filterCategory(category) {
    let rows = document.querySelectorAll('#itemsTableBody tr');
    rows.forEach(row => {
        if(category === 'all' || row.dataset.category === category) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>

@endsection