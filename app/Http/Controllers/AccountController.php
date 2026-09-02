<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders()->withCount('items')->latest()->get();
        $addresses = $user->addresses()->get();

        return view('account.index', compact('user', 'orders', 'addresses'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->name = $validated['name'];
        $user->phone = $validated['phone'];
        $user->email = $validated['email'];

        if ($request->filled('password')) {
            $request->validate([
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $user->password = $request->password;
        }

        $user->save();

        return back()->with('success', 'Account details updated successfully.');
    }
}