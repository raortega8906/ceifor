<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{

    // Crea un Evento
    public function create(Request $request)
    {

        $this->validate($request, [
            'titulo'     =>  'required',
            'descripcion'  =>  'required',
            'fecha' =>  'required'
        ]);

        Event::insert([
            'titulo'       => $request->input("titulo"),
            'descripcion'  => $request->input("descripcion"),
            'color'       => $request->input("color"),
            'fecha'        => $request->input("fecha")
        ]);

        return back()->with('success', 'Enviado exitosamente!');
    }

    // Muestra en el calendario los Eventos creados en la BD
    public static function show()
    {
        $global['events'] = Event::all();
        return $global;
    }

    // Muestra los detalles del Evento que se selecciona en el calendario
    public function details($id)
    {

        $event = Event::find($id);

        return view("calendar.datails", [
            "event" => $event
        ]);
    }

    // Elimina el Evento
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('calendar')->with('success', 'Deleted successfully');
    }

    // Muestra en el calendario los Eventos creados en la BD otro metodo
    // public function show()
    // {
    //     $data['events'] = Event::all();
    //     return response()->json($data['events']);
    // }

}
