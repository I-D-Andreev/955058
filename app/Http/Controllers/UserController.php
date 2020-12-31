<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    
    public function showCurrentUser()
    {
        return view('users.show', ['user' => Auth::user()]);
    }
}
