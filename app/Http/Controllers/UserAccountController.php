<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAccountRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserAccountController extends Controller
{
    /**
     * Show the registration form.
     */
    public function create()
    {
        return inertia('UserAccount/Create');
    }

    /**
     * Create the account and log the user in.
     */
    public function store(UserAccountRequest $request)
    {
        $user = User::create($request->validated());

        Auth::login($user);

        $request->session()->regenerate();

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Konto zostało utworzone']);

        return redirect()->route('listing.index');
    }
}
