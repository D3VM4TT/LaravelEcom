<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        return view('admin.pages.order.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('admin.pages.order.show', compact('order'));
    }
}
