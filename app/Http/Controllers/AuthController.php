<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;


class AuthController extends Controller
{
    public function login()
    {
        return Inertia::render('Auth/Login');
    }

    public function checkLogin(Request $request)
    {
        $user = User::where('email', $request->login)->first();

        if ($user) {
            $status = 'exist';
        } else {
            $status = 'not exist';
        }
        return response()->json([
            'status' => $status
        ]);
    }

    public function signIn(Request $request)
    {
        $this->validate($request, [
            'login' => 'required',
            'password' => 'required'
        ]);
        if (filter_var($request->login, FILTER_VALIDATE_EMAIL)) {
            if (Auth::attempt(['email' => trim($request->login), 'password' => trim($request->password), 'is_active' => 1])) {
                return response()->json([
                    'status' => 'signed'
                ]);
            } else {
                return response()->json([
                    'message' => 'Неверный пароль!'
                ], 403);
            }
        } else {
            if (Auth::attempt(['phone' => trim($request->login), 'password' => trim($request->password), 'is_active' => true])) {
                return response()->json([
                    'status' => 'signed'
                ]);
            } else {
                return response()->json([
//                    'message' => 'Неверный email (номер телефона) или пароль'
                    'message' => 'Неверный пароль!'
                ], 403);
            }
        }
        return response()->json([
            'message' => 'Введите корректные данные'
        ], 403);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

}

