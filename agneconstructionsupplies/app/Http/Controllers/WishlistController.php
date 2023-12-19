<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\ProductPhotos;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use Alert;
use Session;

class WishlistController extends Controller
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
        $wishlists = Wishlist::join('products', 'wishlists.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.id as pid',
                'products.product_name',
                'products.unit',
                'products.description',
                'products.price',
                'products.quantity',
                'categories.category_name',
            )
            ->where('wishlists.user_id', $uid)->get();
        $photos = ProductPhotos::select()->get();
        $ratings = Rating::select()->get();
        return view('users.wishlist')
            ->with('wishlists', $wishlists)
            ->with('photos', $photos)
            ->with('ratings', $ratings);
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
        $uid = Auth::id();
        $wishlist = Wishlist::where('user_id', $uid)->where('product_id', $id)->first();
        if (!$wishlist) {
            $wishlist = new Wishlist();
            $wishlist->user_id = $uid;
            $wishlist->product_id = $id;
            $save = $wishlist->save();
            if ($save) {
                Alert::success('Success', 'Item added to wishlist');
            } else {
                Alert::error('Error', 'Something went wrong');
            }
        }
        $this->updateWishlist();

        return redirect('/wishlist');
    }




    public function addWishlist(Request $request, $id)
    {
        //
        $uid = Auth::id();
        $wishlist = Wishlist::where('user_id', $uid)->where('product_id', $id)->first();
        if (!$wishlist) {
            $wishlist = new Wishlist();
            $wishlist->user_id = $uid;
            $wishlist->product_id = $id;
            $save = $wishlist->save();

        }
        $this->updateWishlist();
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
        $wishlist = Wishlist::find($id);
        if ($wishlist) {
            $wishlist->delete();

        }
        $this->updateWishlist();
        return redirect()->back();
    }

    public function updateWishlist()
    {
        $uid = Auth::id();
        $wishlists = Wishlist::select()->get();
        $wishlist_count = $wishlists->where('user_id', $uid)->count();

        return Session::put('wishlist_count', $wishlist_count);
    }
}
