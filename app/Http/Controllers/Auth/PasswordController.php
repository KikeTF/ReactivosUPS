<?php

namespace ReactivosUPS\Http\Controllers\Auth;

use ReactivosUPS\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Validator;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    //use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getChange()
    {
        return view('security.changePassword');
    }

    public function postChange(Request $request)
    {
        try
        {
            if( !$this->validator($request->all())->fails() )
            {
                if( \Hash::check($request->old_password, \Auth::user()->Password) )
                {
                    \Auth::user()->setPasswordAttribute($request->new_password);
                    //$user->estado = !isset( $request['estado'] ) ? 'I' : 'A';
                    \Auth::user()->modificado_por = \Auth::id();
                    \Auth::user()->fecha_modificacion = date('Y-m-d h:i:s');
                    \Auth::user()->save();
                    flash('Contrase&ntilde;a cambiada existosamente', 'success');
                }
                else
                    flash('Contrase&ntilde;a actual no es valida', 'danger')->important();
            }
            else
                flash('Contrase&ntilde;a de confirmaci&oacute;n no coincide', 'danger')->important();

            return view('security.changePassword');
        }
        catch (\Exception $ex)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[PasswordController][postChange] UserId=".\Auth::id()."; Exception: ".$ex);
            return view('security.changePassword');
        }
    }
    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
        ]);
    }

}
