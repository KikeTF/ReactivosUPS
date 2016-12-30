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
use ReactivosUPS\Option;
use ReactivosUPS\Profile;
use Log;

class OptionsComposer
{
    public function compose(View $view)
    {
        $options = [];
        $suboptions = [];
        try{
            $idUsuario = (int)Session::get('idUsuario');
            $idPerfil = (int)Session::get('idPerfil');

            $perfil = Profile::find($idPerfil);
            if($perfil->optionsProfiles->count() > 0){
                foreach($perfil->optionsProfiles as $optionProfile){
                    $ids[] = $optionProfile->id_opcion;
                }
                $suboptions = Option::find($ids)->where('estado','A');
                $options = Option::query()->where('estado', 'A')->where('id_padre', 0)->get();
            }
        }catch (\Exception $ex){
            Log::error("[OptionsComposer][compose] Exception: ".$ex);
        }

        $view->with('options', $options)->with('suboptions', $suboptions);
    }
}