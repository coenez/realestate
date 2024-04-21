<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAccountController extends Controller
{
    public function create()
    {
        return inertia('UserAccount/Create');
    }

    public function store(Request $request) {
        $toValidate = [
            'name' => 'required|string',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8|confirmed',
        ];

        $user = User::create($request->validate($toValidate));

        Auth::login($user);
        event(new Registered($user));

        return redirect()->route('listing.index')
            ->with('success', 'Account created!');
    }
}
