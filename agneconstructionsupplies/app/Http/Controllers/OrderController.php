<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Address;
use App\Models\Order;
use App\Models\Product;
use App\Models\Status;
use App\Models\Rating;
use App\Models\ProductPhotos;
use Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $uid = Auth::id();
        $statuses = Status::select()->get();

        if (Auth::user()->user_type == 'admin') {
            $orders = Order::select()->orderBy('created_at')->get();
            $data = Order::select()->where('status_id', 3)->get()->groupBy(function ($data) {
                return Carbon::parse($data->created_at)->format('M');
            });
            $months = [];
            $monthCount = [];
            foreach ($data as $month => $values) {
                $months[] = $month;
                $monthCount[] = count($values);
            }
            return view('admin.manage_order')
                ->with('orders', $orders)
                ->with('statuses', $statuses)
                ->with('months', $months)
                ->with('monthCount', $monthCount);

        } else {
            $orders = Order::select()->where('user_id', $uid)->orderBy('created_at')->get();
            return view('users.orders')
                ->with('orders', $orders)
                ->with('statuses', $statuses);
        }
    }
    public function cancelOrder($id)
    {
        $order = Order::find($id);
        $order->status_id = 4;
        $order->save();
    }
    public function acceptOrder($id)
    {
        $order = Order::find($id);
        $order->status_id = 2;
        $order->save();
    }
    public function deliveredOrder($id)
    {
        $order = Order::find($id);
        $order->status_id = 5;
        $order->save();
    }

    public function orderReceived($id)
    {
        $order = Order::find($id);
        $order->status_id = 3;
        $order->save();
    }

    public function rateOrder(Request $request)
    {
        $id = $request->input('id');
        $uid = Auth::id();
        $order = Order::find($id);
        $order->isRated = 'yes';
        $order->save();

        $rating = new Rating();
        $rating->user_id = $uid;
        $rating->product_id = $request->input('product_id');
        $rating->rating = $request->input('rate');
        $rating->review = $request->has('feedback') ? $request->input('feedback') : '';
        $rating->save();
        return redirect()->back();
    }

    public function getOrderToship()
    {
        $uid = Auth::id();
        $statuses = Status::select()->get();
        if (Auth::user()->user_type == 'admin') {
            $orders = Order::select()->where('status_id', 1)->orderBy('created_at')->get();
        } else {
            $orders = Order::select()->where('user_id', $uid)->where('status_id', 1)->orderBy('created_at')->get();
        }

        return view('partials.order-list-toship')->with('orders', $orders)->with('statuses', $statuses)->render();
    }
    public function getOrderToreceive()
    {
        $uid = Auth::id();
        $statuses = Status::select()->get();
        if (Auth::user()->user_type == 'admin') {
            $orders = Order::select()->where(function ($query) {
                $query->where('status_id', 2)
                    ->orWhere('status_id', 5);
            })->orderBy('created_at')->get();
        }
        if (Auth::user()->user_type == 'user') {
            $orders = Order::select()->where(function ($query) {
                $query->where('status_id', 2)
                    ->orWhere('status_id', 5);
            })->where('user_id', $uid)->orderBy('created_at')->get();
        }

        return view('partials.order-list-toreceive')->with('orders', $orders)->with('statuses', $statuses)->render();
    }

    public function getOrderCompleted()
    {
        $uid = Auth::id();
        $statuses = Status::select()->get();
        if (Auth::user()->user_type == 'admin') {
            $orders = Order::select()->where('status_id', 3)->orderBy('created_at')->get();
        }
        if (Auth::user()->user_type == 'user') {
            $orders = Order::select()->where('user_id', $uid)->where('status_id', 3)->orderBy('created_at')->get();
        }

        return view('partials.order-list-completed')->with('orders', $orders)->with('statuses', $statuses)->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function checkout(Request $request)
    {
        $uid = Auth::id();
        $addresses = Address::select()->where('user_id', $uid)->get();
        $carts = $request->input('carts');
        $items = [];
        $amount = 0;
        foreach ($carts as $cart) {
            $item = Cart::join('products', 'products.id', '=', 'carts.product_id')
                ->select(
                    'products.id as pid',
                    'products.product_name',
                    'products.unit',
                    'products.description',
                    'carts.amount',
                    'carts.quantity',
                    'carts.id as cid',
                )
                ->where('carts.id', $cart)
                ->first();
            $items[] = $item;
            $amount += $item->amount;
        }
        return view('users.checkout')->with('items', $items)->with('amount', $amount)->with('addresses', $addresses);
    }

    public function placeOrder(Request $request)
    {
        $uid = Auth::id();
        $address = Address::select()->where('isDefault', 1)->where('user_id', $uid)->first();
        $items = $request->input('items');

        foreach ($items as $item) {
            $cart = Cart::find($item);
            $order = new Order();
            $product = Product::find($cart->product_id);

            $order->product_id = $cart->product_id; //FLAG
            $order->user_id = $uid;
            $order->address_id = $address->id;
            $order->status_id = 1;
            $order->amount = $cart->amount;
            $order->quantity = $cart->quantity; //FLAG

            $product->quantity = $product->quantity - $cart->quantity;

            $order->save();
            $product->save();
            $cart->delete();
        }
        $cart = Cart::select()->where('user_id', $uid)->get();
        $cart_count = $cart->count();
        Session::put('cart_count', $cart_count);
        return view('users.order_success');
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $order = Order::select()->where('id', $id)->first();
        $product = Product::select()->where('id', $order->product_id)->first();
        $photos = ProductPhotos::select()->where('product_id', $order->product_id)->get();
        $ratings = Rating::select()->get();
        $address = Address::select()->where('id', $order->address_id)->first();
        return view('users.order_details')
            ->with('product', $product)
            ->with('order', $order)
            ->with('photos', $photos)
            ->with('ratings', $ratings)
            ->with('address', $address);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
