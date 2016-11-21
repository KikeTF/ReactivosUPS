<?php

namespace ReactivosUPS\Http\Controllers;

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

    public function getCampuses(){
        $campus = Campus::query()->where('estado','A')->orderBy('descripcion', 'asc')->lists('descripcion','id');
        return $campus;
    }

    public function getFormats(){
        $formats = Format::query()->where('estado','A')->orderBy('id', 'asc')->lists('nombre','id');
        return $formats;
    }

    public function getFields(){
        $fields = Field::query()->where('estado','A')->orderBy('nombre', 'asc')->get();
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

    public function getDistributive($id_materia, $id_carrera, $id_campus){
        $id_profileUser = 1;//(int)Session::get('id_perfil_usuario');
        $id_periodLocation = 1;//(int)Session::get('id_periodo_sede');

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


}
