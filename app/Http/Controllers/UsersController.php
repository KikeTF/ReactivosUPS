<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\ProfileUser;
use ReactivosUPS\User;
use ReactivosUPS\Profile;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use Datatables;
use Log;


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
        $userProfiles = ProfileUser::query()->where('id_usuario', $id)->get();
        $profilesList = Profile::query()->where('estado','A')->orderBy('nombre', 'asc')->get();

        return view('security.users.edit')
            ->with('user', $user)
            ->with('userProfiles', $userProfiles)
            ->with('profilesList', $profilesList);
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
        $user = User::find($id);
        \DB::beginTransaction(); //Start transaction!

        try
        {
            if(!is_null($request->password) and  $request->password != "")
                $user->password = \Hash::make($request->password);

            $profiles = array();
            foreach ($request->perfiles as $perfil) {
                if(User::find($user->id)->profilesUsers()->where('id_perfil', $perfil)->count() == 0){
                    $profile['id_perfil'] = $perfil;
                    $profile['id_usuario'] = $id;
                    $profile['creado_por'] = \Auth::id();
                    $profile['fecha_creacion'] = date('Y-m-d h:i:s');
                    $profiles[] = new ProfileUser($profile);
                }
            }

            $user->username = $request->username;
            $user->tipo = $request->tipo;
            $user->estado = !isset( $request['estado'] ) ? 'I' : 'A';
            $user->modificado_por = \Auth::id();
            $user->fecha_modificacion = date('Y-m-d h:i:s');

            $user->save();
            User::find($user->id)->profilesUsers()->saveMany($profiles);
            User::find($user->id)->profilesUsers()->whereNotIn('id_perfil', $request->perfiles)->delete();

            flash('Transacci&oacuten realizada existosamente', 'success');
        }
        catch(\Exception $ex)
        {
            \DB::rollback();
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[UsersController][update] Datos: Request=".$request->all()."; id=".$id.". Exception: ".$ex);
            return redirect()->route('security.users.edit', $id);
        }

        \DB::commit();
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
        try
        {
            $user->estado = 'I';
            $user->modificado_por = \Auth::id();
            $user->fecha_modificacion = date('Y-m-d h:i:s');
            $user->save();
            flash('Transacci&oacuten realizada existosamente', 'success');
        }catch (\Exception $ex)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[UsersController][destroy] Datos: id=".$id.". Exception: ".$ex);
        }

        return redirect()->route('security.users.index');
    }


}
