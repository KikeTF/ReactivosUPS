<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use Log;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try
        {
            if($this->isSessionExpire())
                return redirect()->guest('auth/login');

            if(\Auth::user()->cambiar_password == 'S')
                return redirect()->route('account.changePassword');

            if(\Session::get('Dashboard') == 'S')
                return redirect()->route('dashboard.index');

            return view('index');
        }
        catch(\Exception $ex)
        {
            Log::error("[HomeController][index] Exception: ".$ex);
            return redirect()->guest('auth/login');
        }
    }

}
