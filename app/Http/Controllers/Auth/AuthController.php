<?php

namespace ReactivosUPS\Http\Controllers\Auth;

use Auth;
use Dompdf\Exception;
use ReactivosUPS\Notification;
use ReactivosUPS\Profile;
use Session;
use View;
use ReactivosUPS\User;
use Validator;
use ReactivosUPS\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Log;

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
        $this->middleware('guest', ['except' => array('getLogout', 'userProfile')]);
    }

    public function getLogin()
    {
        if (Auth::check()){
            if(!$this->isSessionExpire())
                return redirect()->guest('/');
        }

        return View::make('auth.login');
    }

    public function getUserProfiles(Request $request)
    {
        $errMessage = "";
        $valid = false;
        try{
            $user = User::query()->where('username', $request->username)->first();
            if(!is_null($user)){
                if($user->estado == "A"){
                    if($user->profilesUsers->count() > 0){
                        foreach($user->profilesUsers as $userProfile){
                            $ids[] = $userProfile->id_perfil;
                        }
                        $profiles = Profile::find($ids);
                        return array('valid' => true, 'profiles' => $profiles);
                    }else
                        $errMessage = "El usuario no tiene roles asignados!";
                }else
                    $errMessage = "El usuario no se encuentra activo!";
            }else
                $errMessage = "El usuario es incorrecto!";
        }catch (Exception $e){
            $errMessage = "El usuario es incorrecto!";
        }

        return array("valid" => $valid, "message" => $errMessage);
    }

    public function postLogin(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        $idProfile = (int)$request->profile;
        $rememberMe = (bool)(isset( $request['rememberMe'] ) ? true : false);
        $errMessage = "";
        //dd(\Hash::make($password));

        if (Auth::attempt(['username' => $username, 'password' => $password, 'estado' => 'A'], $rememberMe)) {
            if($this->loadSessionData($idProfile, Auth::id())){
                return redirect()->guest('home');
            }else
                $errMessage = "Perfil del usuario no encontrado!";
        }else
            $errMessage = "El usuario o contraseña son incorrectos!";


        return view("auth.login")
            ->with("message", $errMessage);
    }

    public function getLogout(){
        Auth::logout();
        return redirect()->guest('auth/login');
    }

    public function postForgotPassword(Request $request){
        try
        {
            $user = User::query()
                ->where('username', $request->username2)->first();

            if( !is_null($user) )
            {
                $notification = Notification::query()
                    ->where('id_usuario', $user->id)->where('tipo', 'PWD')->where('estado', 'A')->first();

                if( is_null($notification))
                {
                    $notif = ['id_usuario' => $user->id, 'fecha' => date('Y-m-d h:i:s'), 'tipo' => 'PWD', 'veces' => 1, 'estado' => 'A'];
                    $notification = new Notification($notif);
                    flash("Solicitud de contrase&ntilde;a enviada!")->important();
                }
                else
                {
                    $notification->modificado_por = $user->id;
                    $notification->fecha_modificacion = date('Y-m-d h:i:s');
                    $notification->veces = ((int)$notification->veces)+1;
                    flash("Ya existe una solicitud de contrase&ntilde;a en tramite!")->important();
                }

                $notification->save();
            }
            else
            {
                flash("El usuario no se encuentra registrado!", "danger")->important();
                Log::alert("[AuthController][postForgotPassword] username=".$request->username2."; El usuario no se encuentra registrado.");
            }

        }
        catch (\Exception $ex)
        {
            flash("No se pudo enviar la solicitud de contrase&ntilde;a. Por favor contacte al administrador!", "danger")->important();
            Log::error("[AuthController][postForgotPassword] username=".$request->username2."; Exception: ".$ex);
        }

        return redirect()->guest('auth/login');
    }

    public function userProfile()
    {
        return view('account.userProfile');
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
    */
}
