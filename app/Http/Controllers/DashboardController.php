<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $lists = Auth::user()->shoppingLists()->with('items')->orderBy('created_at', 'desc')->get();

        // Add calculated fields here or do in the view
        $lists = $lists->map(function ($list) {
            $list->total = $this->calculateTotal($list);
            $list->budgetStatus = $this->getBudgetStatus($list);
            $list->percentage = $list->budget > 0 ? min(100, round(($list->total / $list->budget) * 100)) : 0;
            return $list;
        });

        return view('dashboard', compact('lists'));
    }

    private function calculateTotal($list)
    {
        return $list->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }

    private function getBudgetStatus($list)
    {
        $spent = $this->calculateTotal($list);
        $budget = $list->budget;

        if ($budget == 0) return ['color' => 'gray', 'text' => 'Unknown'];

        $percentage = ($spent / $budget) * 100;

        if ($percentage >= 100) return ['color' => 'red', 'text' => 'Over Budget'];
        if ($percentage >= 80) return ['color' => 'yellow', 'text' => 'Near Limit'];
        return ['color' => 'green', 'text' => 'On Track'];
    }
}