<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
            'customer' => redirect()->route('dashboard'),
            default => abort(403, 'Unauthorized role'),
        };
    }
}
