<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Career;
use ReactivosUPS\CareerProfile;
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

            $careersList = Career::query()
                ->where('estado','A')
                ->orderBy('descripcion', 'asc')
                ->get();

            return view('security.profiles.create')
                ->with('optionsList', $optionsList)
                ->with('careersList', $careersList);
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
            $profile->restablece_password = !isset( $request['restablece_password'] ) ? 'N' : 'S';
            $profile->dashboard = !isset( $request['dashboard'] ) ? 'N' : 'S';
            $profile->estado = !isset( $request['estado'] ) ? 'I' : 'A';
            $profile->creado_por = \Auth::id();
            $profile->fecha_creacion = date('Y-m-d H:i:s');
            $profile->save();

            if (isset($request->careersprofile))
            {
                $careersprofiles = array();
                foreach ($request->careersprofile as $career) {
                    $careersprofile['id_carrera'] = $career;
                    $careersprofile['id_perfil'] = $profile->id;
                    $careersprofile['creado_por'] = \Auth::id();
                    $careersprofile['fecha_creacion'] = date('Y-m-d H:i:s');
                    $careersprofiles[] = new CareerProfile($careersprofile);
                }
                $profile->careersProfiles()->saveMany($careersprofiles);
            }

            if (isset($request->optionsprofile))
            {
                $optionsprofiles = array();
                foreach ($request->optionsprofile as $option) {
                    $optionsprofile['id_opcion'] = $option;
                    $optionsprofile['id_perfil'] = $profile->id;
                    $optionsprofile['creado_por'] = \Auth::id();
                    $optionsprofile['fecha_creacion'] = date('Y-m-d H:i:s');
                    $optionsprofiles[] = new OptionProfile($optionsprofile);
                }
                $profile->optionsProfiles()->saveMany($optionsprofiles);
            }

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

            $optionsList = Option::query()
                ->where('estado','A')
                ->where('id_padre','!=',0)
                ->orderBy('descripcion', 'asc')
                ->get();

            $careersList = Career::query()
                ->where('estado','A')
                ->orderBy('descripcion', 'asc')
                ->get();

            return view('security.profiles.edit')
                ->with('profile', $profile)
                ->with('optionsList', $optionsList)
                ->with('careersList', $careersList);
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
            $profile->nombre = $request->nombre;
            $profile->descripcion = $request->descripcion;
            $profile->aprueba_reactivo = !isset( $request['aprueba_reactivo'] ) ? 'N' : 'S';
            $profile->aprueba_reactivos_masivo = !isset( $request['aprueba_reactivos_masivo'] ) ? 'N' : 'S';
            $profile->aprueba_examen = !isset( $request['aprueba_examen'] ) ? 'N' : 'S';
            $profile->restablece_password = !isset( $request['restablece_password'] ) ? 'N' : 'S';
            $profile->dashboard = !isset( $request['dashboard'] ) ? 'N' : 'S';
            $profile->estado = !isset( $request['estado'] ) ? 'I' : 'A';
            $profile->modificado_por = \Auth::id();
            $profile->fecha_modificacion = date('Y-m-d H:i:s');
            $profile->save();

            if (isset($request->careersprofile))
            {
                $careersprofiles = array();
                foreach ($request->careersprofile as $career) {
                    if($profile->careersProfiles()->where('id_carrera', $career)->count() == 0){
                        $careersprofile['id_carrera'] = $career;
                        $careersprofile['id_perfil'] = $profile->id;
                        $careersprofile['creado_por'] = \Auth::id();
                        $careersprofile['fecha_creacion'] = date('Y-m-d H:i:s');
                        $careersprofiles[] = new CareerProfile($careersprofile);
                    }
                }
                $profile->careersProfiles()->saveMany($careersprofiles);
                $profile->careersProfiles()->whereNotIn('id_carrera', $request->careersprofile)->delete();
            }
            else
            {
                $profile->careersProfiles()->whereNotIn('id_carrera', [0])->delete();
            }

            if (isset($request->optionsprofile))
            {
                $optionsprofiles = array();
                foreach ($request->optionsprofile as $option) {
                    if($profile->optionsProfiles()->where('id_opcion', $option)->count() == 0){
                        $optionsprofile['id_opcion'] = $option;
                        $optionsprofile['id_perfil'] = $profile->id;
                        $optionsprofile['creado_por'] = \Auth::id();
                        $optionsprofile['fecha_creacion'] = date('Y-m-d H:i:s');
                        $optionsprofiles[] = new OptionProfile($optionsprofile);
                    }
                }
                $profile->optionsProfiles()->saveMany($optionsprofiles);
                $profile->optionsProfiles()->whereNotIn('id_opcion', $request->optionsprofile)->delete();
            }
            else
            {
                $profile->optionsProfiles()->whereNotIn('id_opcion', [0])->delete();
            }

            flash('Transacci&oacuten realizada existosamente', 'success');
        }
        catch(\Exception $ex)
        {
            \DB::rollback();
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[ProfilesController][update] Request=". implode(", ", $request->all()) ."; id=".$id."; Exception: ".$ex);
            return redirect()->route('security.profiles.edit', $id);
        }
        finally
        {
            \DB::commit();
        }

        return redirect()->route('security.profiles.show', $id);
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
