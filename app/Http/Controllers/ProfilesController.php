<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Profile;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use Datatables;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profiles = Profile::query()->where('estado','!=','E')->get();
        return view('security.profiles.index')
            ->with('profiles', $profiles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('security.profiles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {

            $profile = new Profile($request->all());
            $profile->estado = !isset( $request['estado'] ) ? 'I' : 'A';
            $profile->creado_por = \Auth::id();
            $profile->fecha_creacion = date('Y-m-d h:i:s');
            $profile->save();
            flash('Transacci&oacuten realizada existosamente', 'success');
        }catch (\Exception $e)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            return view('security.profiles.create');
        }

        return redirect()->route('security.profiles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $profile = Profile::find($id);
        $profile->creado_por = $this->getUserName($profile->creado_por);
        $profile->modificado_por = $this->getUserName($profile->modificado_por);

        return view('security.profiles.show')->with('profile', $profile);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profile = Profile::find($id);
        return view('security.profiles.edit')->with('profile', $profile);
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
        $profile = Profile::find($id);

        try
        {

            $profile->nombre = $request->nombre;
            $profile->descripcion = $request->descripcion;
            $profile->estado = !isset( $request['estado'] ) ? 'I' : 'A';
            $profile->modificado_por = \Auth::id();
            $profile->fecha_modificacion = date('Y-m-d h:i:s');
            $profile->save();

            flash('Transacci&oacuten realizada existosamente', 'success');
        }catch (\Exception $e)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            return view('security.profiles.edit')->with('profile', $profile);
        }

        return redirect()->route('security.profiles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $profile = Profile::find($id);

        try
        {
            $profile->estado = 'E';
            $profile->modificado_por = \Auth::id();
            $profile->fecha_modificacion = date('Y-m-d h:i:s');
            $profile->save();

            flash('Transacci&oacuten realizada existosamente', 'success');
        }catch (\Exception $e)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
        }

        return redirect()->route('security.profiles.index');
    }
}
