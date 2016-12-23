<?php

namespace ReactivosUPS\Http\Controllers\Auth;

use Auth;
use Session;
use View;
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
    use AuthenticatesAndRegistersUsers;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function getLogin()
    {
        // Verificamos si hay sesión activa
        if (Auth::check())
        {
            // Si tenemos sesión activa mostrará la página de inicio
            return redirect()->guest('/');
        }
        // Si no hay sesión activa mostramos el formulario
        return View::make('auth.login');
    }

    public function postLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $rememberMe = $request->input('rememberMe');

        $valid = false;
        $errMessage = "El usuario o contraseña son incorrectos!";
        //dd(\Hash::make($password));

        if (Auth::attempt(['username' => $username, 'password' => $password], $rememberMe)) {
            $valid = true;
            $errMessage = "";
            Session::put('id_sede', 1);
            Session::put('id_periodo', 1);
            Session::put('id_periodo_sede', 1);
            Session::put('id_perfil', 1);
            Session::put('id_perfil_usuario', 1);
        }

        $result = array("valid"=>$valid, "message"=>$errMessage);

        return json_encode($result);
    }

    public function getLogout(){
        Auth::logout();
        return view('auth.login');
    }

    protected $redirectPath = '/';

    protected $loginPath = 'auth.login';

    /*
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

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
    */
}
