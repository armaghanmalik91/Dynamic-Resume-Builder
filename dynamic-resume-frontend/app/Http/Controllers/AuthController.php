<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showRegisterForm() {
        // Yeh views/auth/register.blade.php file ko load karega
        return view('auth.register'); 
    }
}