<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeRedirectController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $user = auth()->user();

        return match ($user->role) {
            'admin' => redirect()->route('admin.index'),
            'customer' => redirect()->route('user.index'),
            default => abort(403, 'Unauthorized role'),
        };
    }
}
