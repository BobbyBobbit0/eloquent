@extends('layouts.app')

@section('content')
<h2>Order #{{ $order->id }}</h2>
<p>Customer: {{ $order->customer->name }}</p>  {{-- No extra query --}}
<p>Status: {{ $order->status }}</p>

<table>
    @foreach($order->products as $product)  {{-- No extra query --}}
    <tr>
        <td>{{ $product->name }}</td>
        <td>{{ $product->pivot->quantity }}</td>
        <td>${{ $product->pivot->unit_price }}</td>
    </tr>
    @endforeach
</table>

<p>Total: ${{ $order->total }}</p>
@endsection