<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Session;

/**
 * @OA\Info(
 *     title="Authentication APIs and Rendering Components",
 *     version="1.0.0",
 *     description="API for user authentication and registration and UI using inertia and vue"
 * )
 */

class AuthController extends Controller
{
    /**
     * Display the login form.
     *
     * @return Response
     *
     * @OA\Get(
     *     path="/",
     *     summary="Display the login form",
     *     @OA\Response(response=200, description="Login form displayed"),
     * )
     */

    public function showLoginForm(){
        return Inertia::render('Auth/Login');
    }

    /**
     * Display the registration form.
     *
     * @return Response
     *
     * @OA\Get(
     *     path="/register",
     *     summary="Display the registration form",
     *     @OA\Response(response=200, description="Registration form displayed"),
     * )
     */

    public function showRegisterForm(){
        return Inertia::render('Auth/Register');
    }

    /**
     * Register a new user.
     *
     * @param Request $request
     * @return RedirectResponse
     *
     * @OA\Post(
     *     path="/register",
     *     summary="Register a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password"),
     *         )
     *     ),
     *     @OA\Response(response=200, description="User registered successfully"),
     *     @OA\Response(response=422, description="Validation error"),
     * )
     */

    public function register(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if($user){
            return redirect()->route('login')->with('success','User created Successfully. Please login here!');
        }
        return redirect()->route('login')->with('error','Unable to register User!');
    }

    /**
     * Authenticate a user and generate a token upon successful login.
     *
     * @param Request $request
     * @return Response
     *
     * @OA\Post(
     *     path="/login",
     *     summary="Authenticate a user and generate a token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password"),
     *         )
     *     ),
     *     @OA\Response(response=200, description="User authenticated successfully"),
     *     @OA\Response(response=401, description="Unauthorized"),
     * )
     */

    public function login(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return Inertia::render('Auth/Login', [
                'token' => $token
            ]);
        }
        return Inertia::render('Auth/Login', [
            'message'   =>  'Unauthorized'
        ]);
    }

    /**
     * Log out a user and clear their tokens and session data.
     *
     * @return RedirectResponse
     *
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Log out a user and clear tokens and session data",
     *     @OA\Response(
     *         response=200,
     *         description="User logged out successfully",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     ),
     * )
     */

    public function getLogoutUser(){
        auth('sanctum')->user()->tokens()->delete();

        Session::flush();

        return redirect()->route('login')->with('success','You are logged out!');
    }
}
