<?php

namespace App\Http\Controllers\Monolith\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WebAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function loginSubmit(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginData = User::where('email', $credentials['email'])->first();
        if (!$loginData) {
            Log::error("User not found: " . $credentials['email']);
            return redirect()->back()->withErrors(['error' => 'Email does not exist.']);
        }
        if (!password_verify($credentials['password'], $loginData->password)) {
            return redirect()->back()->withErrors(['error' => 'The provided password is incorrect.']);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirectRole();
        }

        return back()->withErrors([
            'password' => 'Server Error',
        ]);
    }

    public function redirectRole()
    {
        $authUser = Auth::user()->id;
        $user = User::with('roles')->where('id', $authUser)->first();
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('guru')) {
            return redirect()->route('guru.dashboard');
        } else {
            return redirect()->route('siswa.dashboard');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.page');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function registrationSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.unique' => 'Email sudah digunakan.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole('siswa');
        $user->siswa()->create([
            'name' => $request->name,
        ]);

        Auth::login($user);
        return redirect()->route('profile.index');
    }
}
