<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function Login(LoginRequest $request)
    {
        $a = $request->authenticate();

        Log::info('AuthentificatedSessionController:'.$a);
        //$token = $request->session()->regenerate();
        $token = $request->user()->createToken($request->userAgent())->plainTextToken;
        //$user= $request->user();
        //$user['rol']=User::find($user['id'])->load('roles')->roles[0]->name;
        //return $user;
        if ($request->wantsJson()) {
            return response()->json(['user' => $request->user(), 'token' => $token]);
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($request->wantsJson()) {
            return response()->noContent();
        }

        return redirect('/');
    }

    /**
     * Create User
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = User::where('DNI', $request['DNI'])->first();

        if ($user) {
            return response(['error' => 1, 'message' => 'user already exists'], 409);
        }

        $user = User::create([
            'fullName' => $request['fullName'],
            'email' => $request['email'],
            'phonenumber' => $request['number'],
            'DNI' => $request['DNI'],
            'password' => Hash::make($request['password']),
            'remember_token' => Null,
        ]);

        $role = Role::find($request['role_id']);

        if ($role) {
            $user->assignRole($role); // Assuming you are using Spatie Roles & Permissions
        }

        return $this->successResponse($user, 'Registration Successfully');
    }
}
