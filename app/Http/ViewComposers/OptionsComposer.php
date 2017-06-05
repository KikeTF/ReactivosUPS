<?php
/**
 * Created by PhpStorm.
 * User: Neptali Torres F
 * Date: 30/12/2016
 * Time: 2:19
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
            $currentRoute = substr(\Request::route()->getName(), 0, strripos(\Request::route()->getName(),'.'));

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
                        $subIds = $perfilUsuario->profile->optionsProfiles->pluck('id_opcion')->toArray();
                }
                else
                    $subIds = $perfilUsuario->profile->optionsUsers->pluck('id_opcion')->toArray();

                if( isset($subIds) )
                {
                    $suboptions = Option::find($subIds)->where('estado','A');
                    $ids = $suboptions->pluck('id_padre')->toArray();
                    $options = Option::find(array_unique($ids))->where('estado', 'A')->where('id_padre', 0);

                    if ( isset($options) && isset($suboptions) )
                    {
                        // Valida si ruta es permitida
                        $isValidRoute = (bool)false;
                        foreach ($suboptions->pluck('ruta')->toArray() as $key => $route)
                        {
                            $isValidRoute = (bool)($currentRoute === substr($route, 0, strripos($route,'.')));
                            if($isValidRoute)
                                break;
                        }

                        if ( $isValidRoute )
                            $view->with('navOptions', $options)->with('navSuboptions', $suboptions);
                        else
                            dd(123);
                    }

                }
            }
        }
        catch (\Exception $ex)
        {
            Log::error("[OptionsComposer][compose] Exception: ".$ex);

        }

        $view;
    }
}