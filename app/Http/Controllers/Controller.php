<?php

namespace ReactivosUPS\Http\Controllers;

use Dompdf\Exception;
use ReactivosUPS\Period;
use ReactivosUPS\PeriodLocation;
use ReactivosUPS\ReagentState;
use Session;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use ReactivosUPS\Area;
use ReactivosUPS\CareerCampus;
use ReactivosUPS\ContentDetail;
use ReactivosUPS\Distributive;
use ReactivosUPS\Field;
use ReactivosUPS\MatterCareer;
use ReactivosUPS\Mention;
use ReactivosUPS\ProfileUser;
use ReactivosUPS\ReagentParameter;
use ReactivosUPS\User;
use ReactivosUPS\Campus;
use ReactivosUPS\Career;
use ReactivosUPS\Matter;
use ReactivosUPS\Format;



abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    public function getUserName($id){
        $userName = "";
        if( !is_null($id) ){
            $user = User::find($id);
            $userName = $user->nombres." ".$user->apellidos;
        }
        return $userName;
    }

    public function getUsers(){
        $contents = User::query()->orderBy('nombres', 'asc')->get();
        $contents = $contents->lists('FullName', 'id');
        return $contents;
    }

    public function getCampuses(){
        $campus = Campus::query()->where('estado','A')->orderBy('descripcion', 'asc')->lists('descripcion','id');
        return $campus;
    }

    public function getFormats(){
        $formats = Format::query()->where('estado','A')->orderBy('id', 'asc')->lists('nombre','id');
        return $formats;
    }

    public function getFields(){
        $fields = Field::query()->where('estado','A')->orderBy('nombre', 'asc')->lists('nombre','id');
        return $fields;
    }

    public function getMatters(){
        $matters = Matter::query()->where('estado','A')->orderBy('descripcion', 'asc')->lists('descripcion','id');
        return $matters;
    }

    public function getAreas(){
        $areas = Area::query()->where('estado','A')->orderBy('descripcion', 'asc')->lists('descripcion','id');
        return $areas;
    }

    public function getCareers(){
        $careers = Career::query()->where('estado','A')->orderBy('descripcion', 'asc')->lists('descripcion','id');
        return $careers;
    }

    public function getMentions(){
        $mentions = Mention::query()->where('estado','A')->orderBy('descripcion', 'asc')->lists('descripcion','id');
        return $mentions;
    }

    public function getContents(){
        $contents = ContentDetail::query()->where('estado','A')->orderBy('capitulo', 'asc')->get();
        $contents = $contents->lists('ContentDescription', 'id');
        return $contents;
    }

    public function getContentsModel(){
        $contents = ContentDetail::query()->where('estado','A')->orderBy('capitulo', 'asc')->get();
        return $contents;
    }

    public function getCareersCampuses(){
        $careersCampuses = CareerCampus::query()->where('estado','A')->orderBy('id', 'asc')->get();
        return $careersCampuses;
    }

    public function getMattersCareers(){
        $mattersCareers = MatterCareer::query()->where('estado','A')->orderBy('id', 'asc')->get();
        return $mattersCareers;
    }

    public function getProfilesUsers(){
        $profilesUsers = ProfileUser::query()->where('estado','A')->orderBy('id', 'asc')->get();
        return $profilesUsers;
    }

    public function getReagentsStates(){
        $reagentsStates = ReagentState::query()
            ->where('estado','A')
            ->where('id','!=',7)
            ->orderBy('id', 'asc')->lists('descripcion','id');;
        return $reagentsStates;
    }

    public function getReagentsStatesLabel(){
        $statesLabel = ReagentState::query()
            ->where('estado','A')
            ->where('id','!=',7)
            ->orderBy('id', 'asc')->lists('etiqueta','id');;
        return $statesLabel;
    }

    public function getDistributive($id_materia, $id_carrera, $id_campus){
        $id_profileUser = (int)Session::get('idPerfilUsuario');
        $id_periodLocation = (int)Session::get('idPeriodoSede');

        $id_careerCampus = $this->getCareersCampuses()
            ->where('id_carrera', $id_carrera)
            ->where('id_campus', $id_campus)
            ->first()->id;

        $id_matterCareer = $this->getMattersCareers()
            ->where('id_materia', $id_materia)
            ->where('id_carrera_campus', $id_careerCampus)
            ->first()->id;

        $distributives = Distributive::query()->where('estado','A')->orderBy('id', 'asc')->get();
        $distributive = $distributives
            ->where('id_periodo_sede', $id_periodLocation)
            ->where('id_materia_carrera', $id_matterCareer)
            ->where('id_perfil_usuario', $id_profileUser)
            ->first();

        return $distributive;
    }

    public function getCareersByCampus($id_campus){
        $careerByCampus = CareerCampus::query()->where('id_campus',$id_campus)->get();
        $career = new Career();
        foreach($careerByCampus as $carByCamp){
            $career = Career::find($carByCamp->id_carrera)->where('estado','A')->get();
        }
        return $career;
    }

    public function getFormatParameters($id_formato){
        $parameters = Format::find($id_formato)->where('estado', 'A')->get();
        return $parameters;
    }

    public function isSessionExpire(){
        if (!(\Session::has('id_sede'))){
            \Auth::logout();
            return true;
        }
        return false;
    }

    public function loadSessionData($idPerfil, $idUsuario){
        $result = false;
        try{
            $idSede = (int)User::find($idUsuario)->id_sede;

            $idPeriodo = (int)Period::query()
                ->where('estado', 'A')
                ->orderBy('fecha_inicio', 'desc')
                ->first()->id;

            $idPerfilUsuario = (int)ProfileUser::query()
                ->where('id_perfil', $idPerfil)
                ->where('id_usuario', $idUsuario)
                ->where('estado', 'A')
                ->first()->id;

            $idPeriodoSede = (int)PeriodLocation::query()
                ->where('id_periodo', $idPeriodo)
                ->where('id_sede', $idSede)
                ->where('estado', 'A')
                ->first()->id;

            Session::put('idSede', $idSede);
            Session::put('idPeriodo', $idPeriodo);
            Session::put('idPeriodoSede', $idPeriodoSede);
            Session::put('idPerfil', $idPerfil);
            Session::put('idPerfilUsuario', $idPerfilUsuario);
            $result = true;
        }catch (Exception $ex){

        }

        return $result;
    }

}
