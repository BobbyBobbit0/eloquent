<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

// Models
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

// Policies
use App\Policies\CustomerPolicy;
use App\Policies\ProductPolicy;
use App\Policies\OrderPolicy;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Customer::class => CustomerPolicy::class,
        Product::class => ProductPolicy::class,
        Order::class => OrderPolicy::class,
        User::class => UserPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}