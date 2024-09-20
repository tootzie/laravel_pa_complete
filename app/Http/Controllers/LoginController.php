<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{

    public function login()
    {
        return view('authentications.login');
    }

    public function register()
    {
        return view('authentications.register');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }


    public function handleGoogleCallback(Request $request)
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();

            // Check if the email exists in the 'users' table
            $existingUser = User::where('email', $user->email)->first();

            if (!$existingUser) {
                return redirect()->route('login')->withErrors(['email' => 'Maaf anda tidak diijinkan untuk mengakses halaman ini']);
            }

            $finduser = User::where('google_id', $user->id)->first();
            if($finduser){
                Auth::guard('web')->login($finduser);
                $request->session()->regenerate();

                return redirect()->route('dashboard');
            } else {
                // $newUser = User::create([
                //     'name' => $user->name,
                //     'google_id'=> $user->id,
                //     'avatar'=> $user->avatar,
                //     'password' => encrypt('123456dummy')
                // ]);
                $existingUser->update([
                    'name' => $user->name,
                    'google_id'=> $user->id,
                    'avatar'=> $user->avatar,
                    'password' => encrypt('123456dummy')
                ]);

                Auth::guard('web')->login($existingUser);
                $request->session()->regenerate();
                return redirect()->route('dashboard');
            }
        } catch (Exception $e) {
            return redirect()->route('login');
            // dd($e);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        return redirect()->route('dashboard')
        ->withSuccess('You have successfully registered & logged in!');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect()->route('dashboard')
                ->withSuccess('You have successfully logged in!');
        }

        return back()->withErrors([
            'email' => 'Email atau passwordnya masih salah nih',
        ])->onlyInput('email');

    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');;
    }
}
