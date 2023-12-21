<?php

namespace App\Http\Controllers\API;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class CustomerController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $customer = Customer::where('username', $request->username)->first();

        if(! $customer || ! Hash::check($request->password, $customer->password)){
            throw ValidationException::withMessages([
                'username' => ['Username or Password is failded']
            ]);
        }

        return $customer->createToken('customer token')->plainTextToken;
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'required|min:11',
        ]);

        $customer = Customer::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        return response()->json(['customer' => $customer, 'message' => 'Customer registered successfully'], 201);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
    }

    public function about(Request $request) {
        return response()->json(Auth::user());
    }
}
