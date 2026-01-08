<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where('role', 'customer')->get();
        return Inertia::render('Admin/User/Index', ['user' => $user]);
    }
    public function show(string $id)
    {
        $user = User::where('role', 'customer')->findOrFail($id);
        return Inertia::render('Admin/User/Edit', ['user' => $user]);
    }

    public function update(Request $request, string $id)
    {
        //
    }
    public function destroy(string $id)
    {
        //
    }
}
