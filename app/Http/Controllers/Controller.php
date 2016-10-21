<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use ReactivosUPS\User;

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

}
