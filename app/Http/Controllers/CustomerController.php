<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware; // Required for modern middleware
use Illuminate\Support\Facades\Gate; // Alternative to $this->authorize

class CustomerController extends Controller
{
    public function index()
    {
        // Check if user is allowed to view customers
        Gate::authorize('viewAny', Customer::class);

        // Eager loading 'orders' prevents N+1 query issues
        $customers = Customer::with('orders')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('customers.index', compact('customers'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Customer::class);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        // Creating via relationship automatically sets the user_id
        auth()->user()->customers()->create($data);

        return redirect()->route('customers.index')->with('success', 'Customer created.');
    }

    public function update(Request $request, Customer $customer)
    {
        Gate::authorize('update', $customer);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $customer->update($data);

        return redirect()->route('customers.index')->with('success', 'Customer updated.');
    }

    public function destroy(Customer $customer)
    {
        Gate::authorize('delete', $customer);

        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted.');
    }
}