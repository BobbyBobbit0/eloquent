<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Order::class);

        // Eager-loading both the owner (customer) and the items (products)
        $orders = Order::with(['customer', 'products'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Order::class);

        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'total_amount' => 'required|numeric',
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $order = auth()->user()->orders()->create([
            'customer_id' => $data['customer_id'],
            'total_amount' => $data['total_amount'],
        ]);

        // Attach products to the many-to-many relationship
        $order->products()->attach($data['product_ids']);

        return redirect()->route('orders.index')->with('success', 'Order placed successfully.');
    }

    public function show(Order $order)
    {
        Gate::authorize('view', $order);

        // Ensure relations are loaded for the single view too
        $order->load(['customer', 'products']);

        return view('orders.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        Gate::authorize('delete', $order);

        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order cancelled.');
    }
}