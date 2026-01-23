<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('status', '!=', 'pending')->where('user_id', auth()->id())->with('orderItems.product')->get();
        return Inertia::render('Admin/User/Order/Index', ['orders' => $orders]);
    }
}
