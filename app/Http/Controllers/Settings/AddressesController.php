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

    /**
     * Remove the specified resource from storage.
     */
}
