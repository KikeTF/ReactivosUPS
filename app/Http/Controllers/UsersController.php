<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\User;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use Datatables;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::query()->where('estado','!=','E')->get();
        return view('security.users.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        dd("No disponible!");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd("No disponible!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $user->creado_por = $this->getUserName($user->creado_por);
        $user->modificado_por = $this->getUserName($user->modificado_por);

        return view('security.users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('security.users.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $user = User::find($id);

        if(!is_null($request->password) and  $request->password != "")
            $user->password = \Hash::make($request->password);

        $user->username = $request->username;
        $user->tipo = $request->tipo;
        $user->estado = !isset( $request['estado'] ) ? 'I' : 'A';
        $user->modificado_por = \Auth::id();
        $user->fecha_modificacion = date('Y-m-d h:i:s');
        $user->save();

        return redirect()->route('security.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        $user->estado = 'E';
        $user->modificado_por = \Auth::id();
        $user->fecha_modificacion = date('Y-m-d h:i:s');
        $user->save();


        return redirect()->route('security.users.index');
    }


}
