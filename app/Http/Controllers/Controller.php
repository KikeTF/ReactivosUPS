<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use ReactivosUPS\Area;
use ReactivosUPS\CareerCampus;
use ReactivosUPS\Mention;
use ReactivosUPS\User;
use ReactivosUPS\Campus;
use ReactivosUPS\Career;

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
        $campus = Campus::query()->where('estado','A')->orderBy('descripcion', 'asc')->get();
        return $campus;
    }

    public function getAreas(){
        $areas = Area::query()->where('estado','A')->orderBy('descripcion', 'asc')->get();
        return $areas;
    }

    public function getCareers(){
        $careers = Career::query()->where('estado','A')->orderBy('descripcion', 'asc')->get();
        return $careers;
    }

    public function getMentions(){
        $mentions = Mention::query()->where('estado','A')->orderBy('descripcion', 'asc')->get();
        return $mentions;
    }

    public function getCareersCampuses(){
        $careersCampuses = CareerCampus::query()->where('estado','A')->orderBy('id', 'asc')->get();
        return $careersCampuses;
    }

    public function getCareersByCampus($id_campus){
        $careerByCampus = CareerCampus::query()->where('id_campus',$id_campus)->get();
        $career = new Career();
        foreach($careerByCampus as $carByCamp){
            $career = Career::find($carByCamp->id_carrera)->where('estado','A')->get();
        }
        return $career;
    }

}
