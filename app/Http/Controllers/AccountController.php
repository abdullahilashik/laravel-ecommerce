<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders()->latest()->get();
        $addresses = $user->addresses()->get();

        return view('account.index', compact('user', 'orders', 'addresses'));
    }
}
