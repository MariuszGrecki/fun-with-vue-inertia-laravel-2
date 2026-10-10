<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmailVerificationController extends Controller
{
    public function notice(): Response
    {
        return inertia('Auth/VerifyEmail');
    }

    public function send(Request $request): RedirectResponse
    {
        $request->user()->sendEmailVerificationNotification();

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Verification link sent!']);

        return redirect()->back();
    }
}
