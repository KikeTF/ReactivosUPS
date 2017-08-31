<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Area;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use Log;
use ReactivosUPS\User;

class AreasController extends Controller
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
            $areas = Area::query()->where('estado','!=','E')->get();

            return view('general.areas.index')
                ->with('areas',$areas);
        }
        catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[AreasController][index] Exception: ".$ex);
            return redirect()->route('index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('general.areas.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->route('general.areas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try
        {
            $area = Area::find($id);
            $area->creado_por = $this->getUserName($area->creado_por);
            $area->modificado_por = $this->getUserName($area->modificado_por);

            return view('general.areas.show')
                ->with('area', $area);
        }
        catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[AreasController][show] Datos: id=".$id.". Exception: ".$ex);
            return redirect()->route('general.areas.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try
        {
            $area = Area::find($id);


            return view('general.areas.edit')
                ->with('area', $area)
                ->with('usersList', User::query()->where('estado', 'A')->where('tipo','D')->get() );

        }
        catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[AreaController][edit] Datos: id=".$id.". Exception: ".$ex);
            return redirect()->route('general.areas.index');
        }
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
        try
        {
            $area = Area::find($id);

            $area->id_usuario_resp = $request->id_usuario_resp;
            $area->estado = !isset( $request['estado'] ) ? 'I' : 'A';
            $area->modificado_por = \Auth::id();
            $area->fecha_modificacion = date('Y-m-d H:i:s');
            $area->save();

            flash('Transacci&oacuten realizada existosamente', 'success');
        }
        catch (\Exception $ex)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[AreasController][update] id=".$id."; Exception: ".$ex);
            return redirect()->route('general.areas.edit', $id);
        }

        return redirect()->route('general.areas.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
