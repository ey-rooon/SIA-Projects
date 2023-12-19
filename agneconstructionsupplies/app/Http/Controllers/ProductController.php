<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPhotos;
use App\Models\Rating;
use App\Models\User;
use App\Models\Wishlist;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 
        $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.id', 'products.product_name', 'products.unit', 'products.description', 'products.category_id', 'products.price', 'products.quantity', 'products.created_at', 'products.updated_at', 'categories.category_name')
            ->latest('products.updated_at')
            ->get();


        $photos = ProductPhotos::select()->get();

        $categories = Category::select()->get();

        $title = 'Delete product!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('admin.manage_product')->with('categories', $categories)->with('products', $products)->with('photos', $photos);
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
    public function store(Request $request)
    {
        //
        $photos = $request->file('photo');

        $rules = [
            'photo' => 'required|array',
            'photo.*' => 'file|max:20480|mimes:jpeg,png,gif',
            'prod_name' => 'required',
            'prod_unit' => 'required',
            'prod_desc' => 'required',
            'category' => 'required',
            'prod_quan' => 'required|numeric',
            'prod_price' => 'required|numeric',

        ];

        $customMessages = [
            'photo.*.file' => 'Invalid file format. Please upload a valid file.',
            'photo.*.max' => 'The file size should not exceed 20MB.',
            'photo.*.mimes' => 'Only JPEG, PNG, files are allowed.',
        ];

        $this->validate($request, $rules, $customMessages);

        $product = Product::create([
            'product_name' => $request->prod_name,
            'description' => $request->prod_desc,
            'unit' => $request->prod_unit,
            'category_id' => $request->category,
            'price' => $request->prod_price,
            'quantity' => $request->prod_quan,
        ]);

        $product_id = $product->id;
        foreach ($photos as $photo) {
            $productPhoto = new ProductPhotos();
            $filename = $photo->getClientOriginalName();
            if ($photo->storeAs('public/images/', $filename)) {
                $productPhoto->product_id = $product_id;
                $productPhoto->file_name = $filename;
                $productPhoto->save();
            }
        }

        if ($product) {
            session()->flash('success', 'Product Added successfully.');
        } else {
            session()->flash('error', 'Something went wrong, please try again.');
        }

        return redirect()->back();

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
        $product = Product::join('categories', 'products.category_id', '=', 'categories.id')
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
            ->where('products.id', $id)
            ->first();


        $ratings = Rating::select()->where('product_id', $id)->get();
        $photos = ProductPhotos::select()->where("product_id", $id)->get();
        $users = User::select()->get();
        $wishlists = Wishlist::select()->where('product_id', $id)->get();
        return view("users.product_details")
            ->with("product", $product)
            ->with("photos", $photos)
            ->with("ratings", $ratings)
            ->with('users', $users)
            ->with('wishlists', $wishlists);
    }

    public function getDetails($id)
    {
        $product = Product::join('categories', 'products.category_id', '=', 'categories.id')
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
            ->where('products.id', $id)
            ->first();


        $ratings = Rating::select()->where('product_id', $id)->get();
        $photos = ProductPhotos::select()->where("product_id", $id)->get();
        $users = User::select()->get();
        $wishlists = Wishlist::select()->where('product_id', $id)->get();
        return view('components.details-card')
            ->with("product", $product)
            ->with("photos", $photos)
            ->with("ratings", $ratings)
            ->with('users', $users)
            ->with('wishlists', $wishlists)
            ->render();
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
        $rules = [
            'prod_name' => 'required',
            'prod_unit' => 'required',
            'prod_desc' => 'required',
            'category' => 'required',
            'prod_quan' => 'required|numeric',
            'prod_price' => 'required|numeric',

        ];


        $this->validate($request, $rules);

        $product = Product::where('id', $id)->update([
            'product_name' => $request->prod_name,
            'description' => $request->prod_desc,
            'unit' => $request->prod_unit,
            'category_id' => $request->category,
            'price' => $request->prod_price,
            'quantity' => $request->prod_quan,
        ]);

        if ($product) {
            session()->flash('info', 'Product Updated successfully.');
        } else {
            session()->flash('error', 'Something went wrong, please try again.');
        }

        return redirect()->back();
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
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            Alert::success('Success', 'Product Deleted');
            //session()->flash('success', 'Product Deleted successfully.');
        } else {
            // Add a flash message to indicate that the record was not found
            session()->flash('error', 'Something went wrong, please try again.');
        }

        return redirect()->back();
    }
}