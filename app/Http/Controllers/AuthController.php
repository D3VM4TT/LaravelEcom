<?php

namespace App\Http\Controllers;

use App\Helpers\MessageHelper;
use App\Http\Requests\StoreUser;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login()
    {
        return view('pages.auth.login');
    }

    /**
     * @return Application|Factory|View
     */
    public function register()
    {
        return view('pages.auth.register');
    }

    public function postRegister(StoreUser $request)
    {

        // Create User
        $input = $request->all();
        $input['password'] = bcrypt($request->password);

        $user = User::create($input);

        // Login User
        auth()->login($user);

        return back()->with('success', MessageHelper::createdSuccessMessage('User'));
    }

    /**
     * @throws ValidationException
     */
    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email'           => 'required',
            'password'           => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);


    }


    public function logout()
    {
        auth()->logout();

        return back()->with('success', 'Logout successfully.');
    }
}
