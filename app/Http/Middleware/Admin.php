<?php

namespace ReactivosUPS\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use ReactivosUPS\ProfileUser;
use Log;

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
        $route = \Request::route()->getName();
        $routeExceptions = [
            'general.matterscareers.careers',
            'general.matterscareers.contents',
            'general.matterscareers.matters',
            'general.matterscareers.mentions',
            'reagent.approvals.comment',
            'reagent.reagents.report'
        ];

        try
        {
            if ($this->auth->user()->cambiar_password === 'N')
            {
                $currentRoute = substr($route, 0, strripos($route,'.')).'.index';
                $idPerfilUsuario = (int)\Session::get('idPerfilUsuario');
                $perfilUsuario = ProfileUser::find($idPerfilUsuario);

                if($perfilUsuario->optionsUsers->count() == 0)
                {
                    if($perfilUsuario->profile->optionsProfiles->count() > 0)
                        $userRoutes = $perfilUsuario->profile->optionsProfiles->pluck('option')->where('estado', 'A')->pluck('ruta')->toArray();
                }
                else
                    $userRoutes = $perfilUsuario->profile->optionsUsers->pluck('option')->where('estado', 'A')->pluck('ruta')->toArray();

                if( (isset($userRoutes) && in_array($currentRoute, array_unique($userRoutes))) || in_array($route, $routeExceptions)  )
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
