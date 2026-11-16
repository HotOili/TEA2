<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('pages.login');
    }

    public function showRegister()
    {
        return view('pages.register');
    }

    public function login(Request $r)
    {
        $data = $r->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ], [], ['login' => 'логин', 'password' => 'пароль']);

        if (Auth::attempt($data, $r->boolean('remember'))) {
            $r->session()->regenerate();

            $to = Auth::user()->isAdmin()
                ? route('admin.orders')
                : route('about');

            if ($r->expectsJson()) {
                return response()->json(['ok' => true, 'redirect' => $to]);
            }

            return redirect()->intended($to);
        }

        if ($r->expectsJson()) {
            return response()->json([
                'ok'     => false,
                'errors' => ['password' => 'Неверный логин или пароль'],
            ], 422);
        }

        return back()
            ->withInput($r->only('login'))
            ->withErrors(['password' => 'Неверный логин или пароль']);
    }

    public function register(Request $r)
    {
        $data = $r->validate([
            'name'       => ['required', 'regex:/^[А-Яа-яЁё\s\-]+$/u', 'max:50'],
            'surname'    => ['required', 'regex:/^[А-Яа-яЁё\s\-]+$/u', 'max:50'],
            'patronymic' => ['nullable', 'regex:/^[А-Яа-яЁё\s\-]+$/u', 'max:50'],
            'login'      => ['required', 'regex:/^[A-Za-z0-9\-]+$/', 'min:3', 'max:100', 'unique:user,login'],
            'email'      => ['required', 'email', 'max:100', 'unique:user,email'],
            'password'   => ['required', 'min:6', 'confirmed'],
            'rules'      => ['accepted'],
        ], [
            'name.regex'         => 'Имя: только кириллица, пробел и тире',
            'surname.regex'      => 'Фамилия: только кириллица, пробел и тире',
            'patronymic.regex'   => 'Отчество: только кириллица, пробел и тире',
            'login.regex'        => 'Логин: только латиница, цифры и тире',
            'login.unique'       => 'Такой логин уже занят',
            'email.unique'       => 'Такой email уже зарегистрирован',
            'password.min'       => 'Пароль не менее 6 символов',
            'password.confirmed' => 'Пароли не совпадают',
            'rules.accepted'     => 'Необходимо согласие с правилами',
        ], [
            'name' => 'имя', 'surname' => 'фамилия', 'patronymic' => 'отчество',
            'login' => 'логин', 'email' => 'email', 'password' => 'пароль',
            'rules' => 'согласие с правилами',
        ]);

        $user = User::create([
            'name'       => $data['name'],
            'surname'    => $data['surname'],
            'patronymic' => $data['patronymic'] ?? '',
            'login'      => $data['login'],
            'email'      => $data['email'],
            'password'   => Hash::make($data['password']),
            'img'        => '',
            'prava'      => 1,
        ]);

        Auth::login($user);
        $r->session()->regenerate();

        if ($r->expectsJson()) {
            return response()->json([
                'ok'       => true,
                'redirect' => route('about'),
                'message'  => 'Регистрация успешна',
            ]);
        }

        return redirect()->route('about')->with('success', 'Регистрация успешна');
    }

    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();

        return redirect()->route('about');
    }
}