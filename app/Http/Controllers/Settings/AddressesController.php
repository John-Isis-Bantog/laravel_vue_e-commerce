<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AddressesController extends Controller
{
    public function index()
    {
        $addresses = Address::where('user_id', auth()->id())->get();
        return Inertia::render('settings/Addresses', ['addresses' => $addresses]);
    }
    public function edit(string $id)
    {
        $address = Address::where('user_id', auth()->id())->where('id', $id)->first();
        return Inertia::render('settings/AddressEdit', ['address' => $address]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        dd($request);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'recipient_name' => 'required|string|max:255',
                'phone' => [
                    'required',
                    'regex:/^09\d{9}$/',
                ],
                'city' => 'required|string|max:255',
                'address_line_1' => 'required|string|max:255',
                'address_line_2' => 'nullable|string|max:255',
                'province' => 'required|string|max:255',
                'postal_code' => 'required|numeric',
            ],
            [
                'phone.regex' => 'Phone number must be 11 digits and start with 09.',
            ]
        );
        $validatedData['user_id'] = auth()->id();
        $validatedData = Address::create($validatedData);
        return redirect()->route('addresses.index')->with('success', 'Address Added Successfully!');
    }

    public function destroy(string $id)
    {
        $address = Address::where('id', $id)->where('user_id', auth()->id())->findOrFail($id);
        $address->delete();
        return redirect()->back()->with('success', 'Address Deleted Successfully!');
    }
}
