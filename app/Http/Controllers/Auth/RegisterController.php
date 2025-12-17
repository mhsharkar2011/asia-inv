<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        // Registration disabled
        return redirect()->route('register');
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request)
    {
        // Registration disabled
        return redirect()->route('register');
    }
}
