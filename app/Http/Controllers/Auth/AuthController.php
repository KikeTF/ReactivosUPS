<?php

namespace ReactivosUPS\Http\Controllers\Auth;

use ReactivosUPS\User;
use Validator;
use ReactivosUPS\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use ReactivosUPS\Http\Requests;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */
    //use AuthenticatesAndRegistersUsers;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getLogin()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $rememberMe = $request->input('rememberMe');

        $valid = true;
        $errMessage = "El usuario o contraseña son incorrectos!";

        //return json_encode($result);
        //return view('index');//redirect()->route('reactivos-ups/index');
        /*
        if (Auth::attempt(['CORREO' => $username, 'CLAVE' => $password])) {
            // Authentication passed...
            //return redirect()->route(reactivos-ups/index);
            $valid = true;
            $errMessage = "";
        }
        */
        $result = array("valid"=>$valid, "message"=>$errMessage);

        return json_encode($result);
    }

    public function postLogin(Request $request)
    {

        $username = $request->input('username');
        $password = $request->input('password');
        $rememberMe = $request->input('rememberMe');

        $valid = false;
        $errMessage = "El usuario o contraseña son incorrectos!";

        //return json_encode($result);
        //return view('index');//redirect()->route('reactivos-ups/index');

        if (Auth::attempt(['CORREO' => $username, 'CLAVE' => $password])) {
            // Authentication passed...
            //return redirect()->route(reactivos-ups/index);
            $valid = true;
            $errMessage = "";
        }

        $result = array("valid"=>$valid, "message"=>$errMessage);

        return json_encode($result);

    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    //protected $redirectPath = '/';

    //protected $loginPath = '/login';

}
