@extends('layouts.app')

@section('content')
<table>
    <thead>
        <tr>
            <th>Name</th><th>Email</th><th>Orders</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($customers as $customer)
        <tr>
            <td>{{ $customer->name }}</td>
            <td>{{ $customer->email }}</td>
            <td>{{ $customer->orders->count() }}</td>  {{-- Eager loaded, no extra query --}}
            <td>
                @can('view', $customer)
                    <a href="{{ route('customers.show', $customer) }}">View</a>
                @endcan

                @can('update', $customer)
                    <a href="{{ route('customers.edit', $customer) }}">Edit</a>
                @endcan

                @can('delete', $customer)
                    <form method="POST" action="{{ route('customers.destroy', $customer) }}">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete?')">Delete</button>
                    </form>
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection