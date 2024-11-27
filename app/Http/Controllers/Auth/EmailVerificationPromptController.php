<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        if ($request->user()->hasVerifiedEmail()) {
            if ($request->user()->role_id === 1) {
                return redirect()->intended(route('dashboard', absolute: false));
            } elseif ($request->user()->role_id === 2) {
                return redirect()->intended(route('welcome', absolute: false));
            }
            return redirect()->intended(route('welcome', absolute: false));
        }

        return view('auth.verify-email');
    }
}
