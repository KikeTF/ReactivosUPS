<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('login.index');//->header('Content-Type', $type);
    }

    public function ValidaLogin(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $rememberMe = $request->input('rememberMe');

        $valid = true;
        $message = $username;
        $result = array("valid"=>$valid, "message"=>$message);

        return json_encode($result);
    }
}
