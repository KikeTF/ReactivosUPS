<?php

/**
 * NOMBRE DEL ARCHIVO   HomeController.php
 *
 * TIPO                 Controlador
 *
 * DESCRIPCIÓN          Gestiona la vista que se desplegara como
 *                      página de inicio de la aplicación.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Http\Requests;
use Log;

class HomeController extends Controller
{
    /**
     * Muestra pagina de Inicio de la aplicacion.
     * Si el perfil del usuario tiene el recurso "Dashboard", redirige a la pagina Dashboard. 
     * Si al usuario se le ha reestablecido la contraseña, redirige a la pagina de Cambio de Contraseña.
     * Si la session expiro o el usuario no esta logeado, redirige a la pagina de Inicio de Sesion.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try
        {
            if($this->isSessionExpire())
                return redirect()->guest('auth/login');

            if(\Auth::user()->cambiar_password == 'S')
                return redirect()->route('account.changePassword');

            if(\Session::get('Dashboard') == 'S')
                return redirect()->route('dashboard.index');

            return view('index');
        }
        catch(\Exception $ex)
        {
            Log::error("[HomeController][index] Exception: ".$ex);
            return redirect()->guest('auth/login');
        }
    }

}
