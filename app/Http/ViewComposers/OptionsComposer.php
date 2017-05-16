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
            $viewNameStart = substr(strtolower($view->getName()), 0, 4);
            $isTestView = ($viewNameStart === 'test') ? true : false;
            
            if ($isTestView === false)
            {
                $idPerfilUsuario = (int)Session::get('idPerfilUsuario');

                $perfilUsuario = ProfileUser::find($idPerfilUsuario);
                if($perfilUsuario->optionsUsers->count() == 0){
                    if($perfilUsuario->profile->optionsProfiles->count() > 0)
                        $subIds = $perfilUsuario->profile->optionsProfiles->pluck('id_opcion')->toArray();
                }else
                    $subIds = $perfilUsuario->profile->optionsUsers->pluck('id_opcion')->toArray();

                if( isset($subIds) ){
                    $suboptions = Option::find($subIds)->where('estado','A');
                    $ids = $suboptions->pluck('id_padre')->toArray();
                    $options = Option::find(array_unique($ids))->where('estado', 'A')->where('id_padre', 0);
                }

                $view->with('navOptions', $options)->with('navSuboptions', $suboptions);
            }
        }
        catch (\Exception $ex)
        {
            Log::error("[OptionsComposer][compose] Exception: ".$ex);

        }

        $view;
    }
}