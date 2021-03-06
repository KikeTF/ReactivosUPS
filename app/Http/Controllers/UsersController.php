<?php

/**
 * NOMBRE DEL ARCHIVO   UsersController.php
 *
 * TIPO                 Controlador
 *
 * DESCRIPCIÓN          Gestiona la consulta y modificación de
 *                      los usuarios de la aplicación.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\ProfileUser;
use ReactivosUPS\User;
use ReactivosUPS\Profile;
use ReactivosUPS\Http\Requests;
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
        try
        {
            $users = User::query()->where('estado', '!=', 'E')->get();
            return view('security.users.index')
                ->with('users', $users);
        }
        catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[UsersController][index] Exception: ".$ex);
            return redirect()->route('index');
        }
    }

    /**
     * Funcionalidad no requerida.
     * Redirecciona a la pagina index de Usuarios.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('security.users.index');
    }

    /**
     * Funcionalidad no requerida.
     * Redirecciona a la pagina index de Usuarios.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->route('security.users.index');
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
            $user = User::find($id);
            $user->creado_por = $this->getUserName($user->creado_por);
            $user->modificado_por = $this->getUserName($user->modificado_por);

            return view('security.users.show')
                ->with('user', $user);
        }
        catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[UsersController][show] Datos: id=".$id.". Exception: ".$ex);
            return redirect()->route('security.users.index');
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
            $user = User::find($id);
            $userProfiles = $user->profilesUsers;
            $profilesList = Profile::query()->where('estado','A')->orderBy('nombre', 'asc')->get();

            return view('security.users.edit')
                ->with('user', $user)
                ->with('userProfiles', $userProfiles)
                ->with('profilesList', $profilesList);

        }
        catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[UsersController][edit] Datos: id=".$id.". Exception: ".$ex);
            return redirect()->route('security.users.index');
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
            \DB::beginTransaction(); //Start transaction!
            
            $user = User::find($id);

            if ( isset($request['password']) )
            {
                if ( !($request->password === '' && $request->password_confirm === '') )
                {
                    if ($request->password === $request->password_confirm)
                    {
                        $user->cambiar_password = 'S';
                        $user->setPasswordAttribute($request->password);
                    }
                    else
                    {
                        flash("La contrase&ntilde;a no coincide! Por favor verifique.", 'danger')->important();
                        return redirect()->route('security.users.edit', $id);
                    }
                }
            }

            $user->estado = !isset( $request['estado'] ) ? 'I' : 'A';
            $user->modificado_por = \Auth::id();
            $user->fecha_modificacion = date('Y-m-d H:i:s');
            $user->save();

            if (isset($request->perfiles))
            {
                $profiles = array();
                foreach ($request->perfiles as $perfil) {
                    if(User::find($user->id)->profilesUsers()->where('id_perfil', $perfil)->count() == 0){
                        $profile['id_perfil'] = $perfil;
                        $profile['id_usuario'] = $id;
                        $profile['creado_por'] = \Auth::id();
                        $profile['fecha_creacion'] = date('Y-m-d H:i:s');
                        $profiles[] = new ProfileUser($profile);
                    }
                }
                $user->profilesUsers()->saveMany($profiles);
                $user->profilesUsers()->whereNotIn('id_perfil', $request->perfiles)->delete();
            }
            else
            {
                $user->profilesUsers()->whereNotIn('id_perfil', [0])->delete();
            }

            flash('Transacci&oacuten realizada existosamente', 'success');
        }
        catch(\Exception $ex)
        {
            \DB::rollback();
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[UsersController][update] id=".$id."; Exception: ".$ex);
            return redirect()->route('security.users.edit', $id);
        }
        finally
        {
            \DB::commit();
        }

        return redirect()->route('security.users.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        try
        {
            $user = User::find($id);
            $user->estado = 'I';
            $user->modificado_por = \Auth::id();
            $user->fecha_modificacion = date('Y-m-d H:i:s');
            $user->save();
            flash('Transacci&oacuten realizada existosamente', 'success');
        }
        catch (\Exception $ex)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[UsersController][destroy] Datos: id=".$id.". Exception: ".$ex);
        }

        return redirect()->route('security.users.index');
    }

}
