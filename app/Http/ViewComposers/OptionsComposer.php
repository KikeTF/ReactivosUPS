<?php
/**
 * NOMBRE DEL ARCHIVO   OptionsComposer.php
 *
 * TIPO                 ViewComposers
 *
 * DESCRIPCIÓN          Gestiona las opciones del menu a las 
 *                      cuales el usuario tiene acceso.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;
use ReactivosUPS\Http\Controllers\Controller;
use ReactivosUPS\Option;
use ReactivosUPS\Profile;
use Log;
use ReactivosUPS\ProfileUser;

class OptionsComposer extends Controller
{
    public function compose(View $view)
    {
        try
        {
            $viewNameStart = substr(strtolower($view->getName()), 0, 4);
            $isAdminView = (bool)(($viewNameStart !== 'test')
                && ($viewNameStart !== 'auth')
                && ($viewNameStart !== 'flas')
                && ($viewNameStart !== 'shar'));

            if ( $isAdminView && \Auth::user()->cambiar_password == 'N')
            {
                $idPerfilUsuario = (int)Session::get('idPerfilUsuario');
                $perfilUsuario = ProfileUser::find($idPerfilUsuario);
                if($perfilUsuario->optionsUsers->count() == 0)
                {
                    if($perfilUsuario->profile->optionsProfiles->count() > 0)
                        $suboptions = $perfilUsuario->profile->optionsProfiles->pluck('option')->where('estado', 'A');
                }
                else
                    $suboptions = $perfilUsuario->profile->optionsUsers->pluck('option')->where('estado', 'A');

                if( isset($suboptions) )
                {
                    $options = Option::find(array_unique($suboptions->pluck('id_padre')->toArray()))
                        ->where('estado', 'A')->where('id_padre', 0);

                    $view->with('navOptions', $options)->with('navSuboptions', $suboptions);
                }
            }
        }
        catch (\Exception $ex)
        {
            Log::error("[OptionsComposer][compose] Exception: ".$ex);
        }
    }
}