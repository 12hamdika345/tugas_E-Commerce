<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm()
    {
        $data = array(
            'title' => 'Login',
        );
        return view('auth.login', $data);
    }

    public function postLogin(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        // 2. Cek kredensial
        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {

            // 3. Regenerasi session (security)
            $request->session()->regenerate();

            $user = Auth::user();

            // 4. Simpan session tambahan (opsional)
            Session::put([
                'user_id' => $user->id,
                'name'    => $user->name,
                'role'    => $user->role,
            ]);

            // 5. Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->route('admin')
                    ->with('success', 'Login berhasil sebagai Admin');
            }

            return redirect()->route('home')
                ->with('success', 'Login berhasil');
        }

        // 6. Login gagal
        return back()->withErrors([
            'email' => 'Email atau password salah',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        // 1. Logout dari Auth
        Auth::logout();

        // 2. Hapus semua session
        Session::flush();

        // 5. Redirect ke halaman login
        return redirect()->route('login')
            ->with('success', 'Anda berhasil logout');
    }
}
