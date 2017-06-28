<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Profile;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use ReactivosUPS\OptionProfile;
use ReactivosUPS\Option;
use Datatables;
use Log;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $profiles = Profile::query()->where('estado','!=','E')->orderBy('nombre','asc')->get();
            return view('security.profiles.index')
                ->with('profiles', $profiles);
        }catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[ProfilesController][index] Exception: ".$ex);
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
        try{
            $optionsList = Option::query()
                ->where('estado','A')
                ->where('id_padre','!=',0)
                ->orderBy('descripcion', 'asc')
                ->get();

            return view('security.profiles.create')
                ->with('optionsList', $optionsList);
        }catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[ProfilesController][create] Exception: ".$ex);
            return redirect()->route('security.profiles.index');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \DB::beginTransaction(); //Start transaction!
        try
        {
            $profile = new Profile($request->all());
            $profile->aprueba_reactivo = !isset( $request['aprueba_reactivo'] ) ? 'N' : 'S';
            $profile->aprueba_examen = !isset( $request['aprueba_examen'] ) ? 'N' : 'S';
            $profile->aprueba_reactivos_masivo = !isset( $request['aprueba_reactivos_masivo'] ) ? 'N' : 'S';
            $profile->estado = !isset( $request['estado'] ) ? 'I' : 'A';
            $profile->creado_por = \Auth::id();
            $profile->fecha_creacion = date('Y-m-d H:i:s');
            $profile->save();

            $optionsprofiles = array();
            foreach ($request->optionsprofile as $option) {
                $optionsprofile['id_opcion'] = $option;
                $optionsprofile['id_perfil'] = $profile->id;
                $optionsprofile['creado_por'] = \Auth::id();
                $optionsprofile['fecha_creacion'] = date('Y-m-d H:i:s');
                $optionsprofiles[] = new OptionProfile($optionsprofile);
            }

            Profile::find($profile->id)->optionsProfiles()->saveMany($optionsprofiles);

            flash('Transacci&oacuten realizada existosamente', 'success');
        }catch (\Exception $ex)
        {
            \DB::rollback();
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[ProfilesController][store] Request=". implode(", ", $request->all()) ."; Exception: ".$ex);
            return redirect()->route('security.profiles.create');
        }

        \DB::commit();
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
        try{
            $profile = Profile::find($id);
            $profile->creado_por = $this->getUserName($profile->creado_por);
            $profile->modificado_por = $this->getUserName($profile->modificado_por);
            foreach($profile->optionsProfiles as $optionProfile){
                $ids[] = $optionProfile->id_opcion;
            }

            $options = [];
            if( isset($ids) )
                $options = Option::find($ids);

            return view('security.profiles.show')
                ->with('profile', $profile)
                ->with('optionsProfiles', $options);
        }catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[ProfilesController][show] Datos: id=".$id.". Exception: ".$ex);
            return redirect()->route('security.profiles.index');
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
        try{
            $profile = Profile::find($id);
            $optionsProfiles = OptionProfile::query()->where('id_perfil', $id)->get();

            $optionsList = Option::query()
                ->where('estado','A')
                ->where('id_padre','!=',0)
                ->orderBy('descripcion', 'asc')
                ->get();

            return view('security.profiles.edit')
                ->with('profile', $profile)
                ->with('optionsProfiles', $optionsProfiles)
                ->with('optionsList', $optionsList);
        }catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[ProfilesController][edit] Datos: id=".$id.". Exception: ".$ex);
            return redirect()->route('security.profiles.index');
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

        $profile = Profile::find($id);
        \DB::beginTransaction(); //Start transaction!

        try
        {
            $optionsprofiles = array();
            foreach ($request->optionsprofile as $option) {
                if(Profile::find($profile->id)->optionsProfiles()->where('id_opcion', $option)->count() == 0){
                    $optionsprofile['id_opcion'] = $option;
                    $optionsprofile['id_perfil'] = $profile->id;
                    $optionsprofile['creado_por'] = \Auth::id();
                    $optionsprofile['fecha_creacion'] = date('Y-m-d H:i:s');
                    $optionsprofiles[] = new OptionProfile($optionsprofile);
                }
            }

            $profile->nombre = $request->nombre;
            $profile->descripcion = $request->descripcion;
            $profile->aprueba_reactivo = !isset( $request['aprueba_reactivo'] ) ? 'N' : 'S';
            $profile->aprueba_reactivos_masivo = !isset( $request['aprueba_reactivos_masivo'] ) ? 'N' : 'S';
            $profile->aprueba_examen = !isset( $request['aprueba_examen'] ) ? 'N' : 'S';
            $profile->estado = !isset( $request['estado'] ) ? 'I' : 'A';
            $profile->modificado_por = \Auth::id();
            $profile->fecha_modificacion = date('Y-m-d H:i:s');
            $profile->save();

            Profile::find($profile->id)->optionsProfiles()->saveMany($optionsprofiles);
            Profile::find($profile->id)->optionsProfiles()->whereNotIn('id_opcion', $request->optionsprofile)->delete();

            flash('Transacci&oacuten realizada existosamente', 'success');
        }
        catch(\Exception $ex)
        {
            \DB::rollback();
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[ProfilesController][update] Request=". implode(", ", $request->all()) ."; id=".$id."; Exception: ".$ex);
            return redirect()->route('security.profiles.edit', $id);
        }

        \DB::commit();
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
            $profile->fecha_modificacion = date('Y-m-d H:i:s');
            $profile->save();

            flash('Transacci&oacuten realizada existosamente', 'success');
        }catch (\Exception $ex)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[ProfilesController][destroy] Datos: id=".$id.". Exception: ".$ex);
        }
        return redirect()->route('security.profiles.index');
    }
}
