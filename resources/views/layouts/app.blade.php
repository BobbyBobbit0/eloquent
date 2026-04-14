<nav>
    <a href="{{ route('customers.index') }}">Customers</a>
    <a href="{{ route('products.index') }}">Products</a>
    <a href="{{ route('orders.index') }}">Orders</a>
    <a href="{{ route('account.show') }}">My Account</a>

    @can('viewAny', App\Models\User::class)
        <a href="{{ route('users.index') }}">Users (Admin)</a>
    @endcan
</nav>