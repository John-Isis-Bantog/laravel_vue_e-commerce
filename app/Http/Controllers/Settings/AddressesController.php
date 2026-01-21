<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AddressesController extends Controller
{

    public function edit()
    {
        return Inertia::render('settings/Addresses');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'city' => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|numeric',
        ]);
        $validatedData['user_id'] = auth()->id();
        $validatedData = Address::create($validatedData);
        return redirect()->route('addresses.edit')->with('success', 'Address Added Successfully!');
    }
}
