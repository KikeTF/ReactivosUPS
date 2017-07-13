<?php

/**
 * NOMBRE DEL ARCHIVO   NotificationsController.php
 *
 * TIPO                 Controlador
 *
 * DESCRIPCIÓN          Responde a las peticiones de información necesaria
 *                      para desplegar las notificaciones en la cabecera 
 *                      de la aplicación.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use Log;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\Notification;

class NotificationsController extends Controller
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
            $typeList = ['PWD' => 'Cambio de Contrase&ntilde;a'];

            $notifications = Notification::query()
                ->where('estado', 'A')->get();

            return view('general.notifications.index')
                ->with('notificationsList', $notifications)
                ->with('typeList', $typeList);
        }
        catch (\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[NotificationsController][index] Exception: ".$ex);
            return redirect()->route('index');
        }

    }

    /**
     * Actualiza el estado de las notificacion seleccionada y 
     * redirige a la pagina para gestionar el requerimiento.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        try
        {
            $notification = Notification::find($id);
            $notification->estado = 'I';
            $notification->save();

            if ($notification->tipo == 'PWD')
                return redirect()->route('security.users.edit', $notification->id_usuario);
        }
        catch (\Exception $ex)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[NotificationsController][update] id=".$id."; Exception: ".$ex);
        }

        return redirect()->route('general.notifications.index');
    }
}
