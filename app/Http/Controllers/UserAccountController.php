<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class UserAccountController extends Controller
{
    public function index()
    {
        return inertia('UserAccount/Index');
    }

    public function show()
    {
        return inertia('UserAccount/Show');
    }

    public function create()
    {
        return inertia('UserAccount/Create');
    }

    public function store(Request $request)
    {
        $user = User::create($request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed'
        ]));

        Auth::login($user);
        event(new Registered($user));

        return redirect()->route('listing.index')
            ->with('success', 'Account created!');
    }
}
