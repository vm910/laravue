<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        return inertia('Index/Index', [
            'message' => 'hello from index'
        ]);

        // Listing::make([
        //     'beds' => 1,
        //     'baths' => 1,
        //     'area' => 1,
        //     'city' => 'city',
        //     'code' => 'code',
        //     'street_nr' => 1,
        //     'street' => 'street',
        //     'price' => 1,
        //     'by_user_id' => 1,
        // ]);
    }

    public function show()
    {
        return inertia('Index/Show', [
            'message' => 'hello from show'
        ]);
    }
}
