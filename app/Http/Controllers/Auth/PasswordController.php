<?php

namespace ReactivosUPS\Http\Controllers\Auth;

use ReactivosUPS\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use ReactivosUPS\Http\Requests\Request;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    //use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'change']);
    }

    public function change()
    {
        return view('security.changePassword');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'old_password' => 'required|min:6',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);
    }

}
