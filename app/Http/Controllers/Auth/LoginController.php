<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Показать шаблон входа
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('auth.login.index');
    }

    /**
     * Залогинить пользователя
     *
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function submit(LoginRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = User::where('login', $data['login'])->withTrashed()->first();

        if ($user->deleted_at !== NULL) {
            return back()->withErrors(['login'=>'Пользователь с таким логином заблокирован.'])->withInput(['login'=>$data['login']]);
        }

        if (Hash::check($data['password'], $user->password)) {
            auth()->login($user);
            if ($user->role->name == 'admin') {
                return redirect()->route('admin.main.index');
            }
            return redirect()->route('profile.progress');

        }

        return back()->withErrors([
            'password' => 'Неверный пароль'
        ])->withInput([
            'login' => $data['login']
        ]);

    }
}
