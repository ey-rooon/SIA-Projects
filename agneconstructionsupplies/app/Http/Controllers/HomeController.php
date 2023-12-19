<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\ProductPhotos;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Wishlist;
use Session;
use App\Models\Rating;
use App\Models\Order;
use Carbon\Carbon;

class HomeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request) {

        $uid = Auth::id();
        $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.id',
                'products.product_name',
                'products.unit',
                'products.description',
                'products.category_id',
                'products.price',
                'products.quantity',
                'products.created_at',
                'products.updated_at',
                'categories.category_name'
            )
            ->latest('products.updated_at')->when($request->filter, function ($query) use ($request) {
                $query->where('category_id', $request->filter);
            })
            ->paginate(8);
        $categories = Category::select()->get();
        $ratings = Rating::select()->get();
        $orders = Order::Select()->get();

        $cart = Cart::select()->where('user_id', $uid)->get();
        $cart_count = $cart->count();

        $wishlists = Wishlist::select()->get();
        $wishlist_count = $wishlists->where('user_id', $uid)->count();

        Session::put('wishlist_count', $wishlist_count);
        Session::put('cart_count', $cart_count);


        $photos = ProductPhotos::select()->get();

        if(Auth::check()) {
            $userType = Auth()->user()->user_type;
            if($userType == 'admin') {

                $productCount = $products->count();
                $revenue = $orders->where('status_id', 3)->sum('amount');
                $orderCount = $orders->whereNotIn('status_id', 4)->count();
                $orders = Order::select()->orderBy('created_at')->get();
                $outOfStock = $products->where('quantity', 0)->count();
                $users = User::select()->where('user_type', '!=', 'admin')->count();

                $labels = $orders->pluck('created_at')->map(function ($date) {
                    return $date->format('Y-m-d'); // Adjust the format as needed
                });
                $data = $orders->pluck('amount');


                return view('admin.dashboard', compact('products', 'productCount', 'revenue', 'orderCount', 'orders', 'labels', 'data', 'outOfStock', 'users', 'categories'));

            } elseif($userType == 'user') {
                return view('home', compact('products', 'photos', 'ratings', 'categories', 'wishlists', 'request'));
            }
        }

        return view('home', compact('products', 'photos', 'ratings', 'categories', 'wishlists', 'request'));
    }

}
