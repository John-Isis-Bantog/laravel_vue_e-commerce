<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rules\Password;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categories = Category::count();
        $allProducts = Product::count();
        $activeProducts = Product::where('is_active', '1')->count();


        $admins = User::where('role', 'admin')
            ->where('id', '!=', auth()->id()) // exclude the current admin
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                });
            })
            ->get();


        return Inertia::render('Admin/Admins/Index', ['admins' => $admins, 'categories' => $categories, 'allProducts' => $allProducts, 'activeProducts' => $activeProducts]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Admins/Create', ['']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users,email|max:255',
            'password' => [
                'required',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],

        ]);
        $validated['role'] = 'admin';
        $validated = User::create($validated);
        return redirect()->route('admin.index')->with('success', 'Admin Added sucessfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        return Inertia::render('Admin/Admins/Edit', ['admin' => $admin]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $admin)
    {
        $validateAdmin = $request->validate([
            'name' => 'required|max:255',
            'email' => 'email:rfc,dns|unique:users,email,' . $admin->id
        ]);
        $admin->update($validateAdmin);
        return redirect()->route('admin.index')->with('success', 'Admin Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = User::where('role', 'admin')->findOrFail($id);
        if (auth()->id() == $admin->id) {
            abort(403, 'You cannot delete your own account!');
        }

        $admin->delete();
        return redirect()->route('admin.index')->with('success', 'Admin Has Been Deleted Successfully!');
    }
}
