<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;
use App\Models\ProductPhotos;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Rules\QuantityRule;
use App\Models\Rating;

class CartController extends Controller
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
        $carts = Cart::join('products', 'carts.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.id as pid',
                'products.product_name',
                'products.unit',
                'products.description',
                'carts.amount',
                'carts.quantity',
                'categories.category_name',
                'carts.id as cid',
            )
            ->where('carts.user_id', $uid)->get();
        
        $cart_count = $carts->count();
        Session::put('cart_count', $cart_count);
        $photos = ProductPhotos::select()->get();
        return view('users.cart')->with('carts', $carts)->with('photos', $photos);
    }

    public function getCart()
    {
        $uid = Auth::id();
        $carts = Cart::join('products', 'carts.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.id as pid',
                'products.product_name',
                'products.unit',
                'products.description',
                'carts.amount',
                'carts.quantity',
                'categories.category_name',
                'carts.id as cid',
            )
            ->where('carts.user_id', $uid)->get();
        $ratings = Rating::select()->get();
        $cart_count = $carts->count();
        Session::put('cart_count', $cart_count);
        $photos = ProductPhotos::select()->get();
        return view('partials.cart-list')->with('carts', $carts)->with('photos', $photos)->with('ratings', $ratings)->render();;
    }

    public function increaseQuan($id)
    {
        $cart = Cart::find($id);
        $product = Product::where('id', $cart->product_id)->first();
        $price = $product->price;
        $cart->quantity = $cart->quantity += 1;
        $cart->amount = $cart->amount += $price;
        $cart->save();
    }

    public function decreaseQuan($id)
    {
        $cart = Cart::find($id);
        $product = Product::where('id', $cart->product_id)->first();
        if ($cart && $product) {
            if ($cart->quantity > 1) {
                $price = $product->price;
                $cart->quantity -= 1;
                $cart->amount -= $price;
                $cart->save();
            }
        }
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
    public function store(Request $request, $id)
    {
        //
        $product = Product::select()->where('id', $id)->first();
        $uid = Auth::id();
        $quantity = $request->input('quantity');
        //add to cart

        $rules = [
            'quantity' => ['required', 'numeric', new QuantityRule($product->quantity)],
        ];
        $this->validate($request, $rules);

        $cart = Cart::select()->where('user_id', $uid)->where('product_id', $product->id)->first();
        $amount = $product->price * $quantity;

        if ($cart) {
            //update existing cart
            if ($cart->count() > 0) {
                $amount += $cart->amount;
                $quantity += $cart->quantity;
                $cart = Cart::where('user_id', $uid)->where('product_id', $product->id)->update([
                    'user_id' => $uid,
                    'product_id' => $product->id,
                    'amount' => $amount,
                    'quantity' => $quantity,
                ]);
            }
        } else {
            //add to cart
            $cart = Cart::create([
                'user_id' => $uid,
                'product_id' => $product->id,
                'amount' => $amount,
                'quantity' => $quantity,
            ]);
        }

        if ($cart) {
            Alert::success('Success', 'Item added to cart');
        } else {
            Alert::error('Error', 'Something went wrong');
        }

        return redirect('/cart');
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
        $cart = Cart::find($id);
        if ($cart) {
            $cart->delete();
            Alert::success('Success', 'Item removed from cart');
        } else {
            Alert::error('Error', 'Something went wrong');
        }

        return redirect('/cart');
    }
}
