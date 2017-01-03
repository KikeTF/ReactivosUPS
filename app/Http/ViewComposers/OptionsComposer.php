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
        $options = [];
        $suboptions = [];
        try{
            $idPerfil = (int)Session::get('idPerfil');
            $idPerfilUsuario = (int)Session::get('idPerfilUsuario');

            $perfilUsuario = ProfileUser::find($idPerfilUsuario);
            if($perfilUsuario->optionsUsers->count() == 0){
                $perfil = Profile::find($idPerfil);
                if($perfil->optionsProfiles->count() > 0){
                    foreach($perfil->optionsProfiles as $optionProfile){
                        $ids[] = $optionProfile->id_opcion;
                    }
                }
            }else{
                foreach($perfilUsuario->optionsUsers as $optionUser){
                    $ids[] = $optionUser->id_opcion;
                }
            }

            if( isset($ids) ){
                $suboptions = Option::find($ids)->where('estado','A');
                $options = Option::query()->where('estado', 'A')->where('id_padre', 0)->get();
            }

        }catch (\Exception $ex){
            Log::error("[OptionsComposer][compose] Exception: ".$ex);
        }

        $view->with('navOptions', $options)->with('navSuboptions', $suboptions);
    }
}