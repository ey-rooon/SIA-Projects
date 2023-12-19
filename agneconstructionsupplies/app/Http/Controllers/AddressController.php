<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Alert;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $userid = auth()->user()->id;
        $addresses = Address::select()->where('user_id', $userid)->get();
        return view('users.address')->with('addresses', $addresses);
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
        $rules = [
            'firstname' => 'required',
            'lastname' => 'required',
            'town' => 'required',
            'barangay' => 'required',
            'street' => 'required',
            'contact' => 'required|regex:/^\d{11}$/',
            'postal_code' => 'required|regex:/^\d{4}$/',
        ];
        $this->validate($request, $rules);
        $userid = auth()->user()->id;
        $address = Address::where('user_id', $userid)->get();
        if ($address->count() > 0) {
            Address::query()->update(['isDefault' => 0]);
        }

        $address = Address::create([
            'user_id' => $userid,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'town' => $request->town,
            'barangay' => $request->barangay,
            'street' => $request->street,
            'contact' => $request->contact,
            'postal_code' => $request->postal_code,
            'isDefault' => 1,
        ]);
        if ($address) {
            Alert::success('Success', 'Address added successfully');
        } else {
            Alert::error('Error', 'Something went wrong');
        }
        return redirect()->back();
    }

    public function getAddressList()
    {
        $uid = Auth::id();
        $addresses =  Address::where('user_id', $uid)->select()->get(); // Fetch all addresses or use your own logic
        return view('partials.address-list', compact('addresses'))->render();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $uid = Auth::id();
        $address = Address::where('user_id', $uid)->where('isDefault', 1)->first();

        return view('partials.default-address', compact('address'))->render();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $uid = Auth::id();

        // Update all addresses of the user to set isDefault to 0
        Address::where('user_id', $uid)->update(['isDefault' => 0]);

        $address = Address::find($id);

        if (!$address) {
            return response()->json(['message' => 'Address not found'], 404);
        }

        // Set the selected address as the default
        $address->isDefault = 1;
        $address->save();

        return ['message' => 'Address set as default'];
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
            'firstname' => 'required',
            'lastname' => 'required',
            'town' => 'required',
            'barangay' => 'required',
            'street' => 'required',
            'contact' => 'required|regex:/^\d{11}$/',
            'postal_code' => 'required|regex:/^\d{4}$/',
        ];
        $this->validate($request, $rules);
        $userid = auth()->user()->id;

        $address = Address::where('id', $id)->update([
            'user_id' => $userid,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'town' => $request->town,
            'barangay' => $request->barangay,
            'street' => $request->street,
            'contact' => $request->contact,
            'postal_code' => $request->postal_code,
        ]);
        if ($address) {
            Alert::success('Success', 'Address updated successfully');
        } else {
            Alert::error('Error', 'Something went wrong');
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
    }
}
