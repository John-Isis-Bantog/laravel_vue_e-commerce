<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

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
            'phoneNumber' => 'required|numeric',
            'city' => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|numeric',
        ]);
        dd($validatedData);
    }
}
