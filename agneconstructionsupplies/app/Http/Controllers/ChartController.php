<?php

namespace App\Http\Controllers;

use App\Models\Order;

use Illuminate\Http\Request;

class ChartController extends Controller
{
    //
    public function index()
    {
        $orders = Order::latest()->sortBy('id')->get();

        $labels = $orders->pluck('created_at')->map(function ($date) {
            return $date->format('Y-m-d'); // Adjust the format as needed
        });
        $data = $orders->pluck('amount');

        return response()->json(compact('labels', 'data'));
    }

}
