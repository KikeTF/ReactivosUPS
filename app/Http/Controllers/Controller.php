<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use ReactivosUPS\CareerCampus;
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
        $campus = Campus::query()->where('estado','A')->get();;
        return $campus;
    }

    public function getCareersByCampus($id_campus){
        $career = Career::query()->where('estado','A')->careersCampuses()->where('id_campus',$id_campus)->get();
        return $career;
    }

}
