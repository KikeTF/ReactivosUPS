<?php

namespace ReactivosUPS\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use ReactivosUPS\ProfileUser;

class Admin
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try
        {
            if ($this->auth->user()->cambiar_password === 'N')
            {
                $currentRoute = substr(\Request::route()->getName(), 0, strripos(\Request::route()->getName(),'.')).'.index';
                $idPerfilUsuario = (int)\Session::get('idPerfilUsuario');
                $perfilUsuario = ProfileUser::find($idPerfilUsuario);

                if($perfilUsuario->optionsUsers->count() == 0)
                {
                    if($perfilUsuario->profile->optionsProfiles->count() > 0)
                        $userRoutes = $perfilUsuario->profile->optionsProfiles->pluck('option')->where('estado', 'A')->pluck('ruta')->toArray();
                }
                else
                    $userRoutes = $perfilUsuario->profile->optionsUsers->pluck('option')->where('estado', 'A')->pluck('ruta')->toArray();

                if( isset($userRoutes) && in_array($currentRoute, array_unique($userRoutes)) )
                {
                    return $next($request);
                }
                else
                    return redirect()->route('index');
            }
            else
                return redirect()->route('account.changePassword');
        }
        catch (\Exception $ex)
        {
            Log::error("[OptionsComposer][compose] Exception: ".$ex);
            return redirect()->route('index');
        }
    }
}
