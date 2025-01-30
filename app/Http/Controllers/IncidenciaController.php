<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\Incidencia;
use Illuminate\Http\Request;

class IncidenciaController extends Controller
{
    /**
     * Muestra una lista de todas las incidencias con búsqueda.
     */
    public function index(Request $request)
    {
        $query = Incidencia::query();

        $search = $request->input('search', ''); // Asignar un valor predeterminado a $search

        if (!empty($search)) {
            $query->where('id_incidencia', 'LIKE', "%{$search}%")
                ->orWhere('titulo', 'LIKE', "%{$search}%");
        }

        // Agregamos orderBy para asegurar el orden correcto
        $incidencias = $query->orderBy('created_at', 'desc')->paginate(14)->appends(['search' => $search]);

        //dd($incidencias);

        return view('incidencias.index', compact('incidencias', 'search'));
    }

    /**
     * Muestra el formulario para crear una nueva incidencia.
     */
    public function create()
    {
        return view('incidencias.create');
    }
    /**
     * ASIGNAR INCIDENCIA METODO.
     */
    public function autoasignar($id)
    {
        $incidencia = Incidencia::findOrFail($id);

        // Verificar si ya está asignada
        if ($incidencia->asignado_a) {
            return redirect()->back()->with('error', 'La incidencia ya está asignada.');
        }

        // Autoasignar la incidencia
        $incidencia->asignado_a = auth()->user()->apellido; // O el campo correspondiente del usuario
        $incidencia->save();

        return redirect()->back()->with('success', 'La incidencia ha sido asignada correctamente.');
    }

    /**
     * Almacena una nueva incidencia en la base de datos.
     */
    public function store(Request $request)
    {
        \Log::info('Datos recibidos en la solicitud:', $request->all());

        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria' => 'required|string',
            'prioridad' => 'required|string',
            'archivo' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        \Log::info('Datos validados:', $validatedData);

        $incidencia = new Incidencia();
        $incidencia->titulo = $validatedData['titulo'];
        $incidencia->descripcion = $validatedData['descripcion'];
        $incidencia->usuario_id = auth()->id();
        $incidencia->prioridad = $validatedData['prioridad'];
        $incidencia->categoria = $validatedData['categoria'];
        $incidencia->estado = 'en proceso';
        $incidencia->save();


        \Log::info('Incidencia guardada:', $incidencia->toArray());


        // Manejar el archivo adjunto si existe
        if ($request->file('archivo')) {
            $archivo = $request->file('archivo');
            $nombre = time() . '_' . $archivo->getClientOriginalName();
            $ruta_archivo = $archivo->storeAs('archivos', $nombre, 'public');

            // Actualizar la incidencia con la ruta del archivo
            $incidencia->archivo = $ruta_archivo;
            $incidencia->save();

            \Log::info('Archivo subido y asociado a la incidencia:', ['ruta' => $ruta_archivo]);

        }


        return redirect()->route('perfil')->with('success', 'Incidencia registrada correctamente.');
        dd("hola");

    }


    /**
     * Muestra los detalles de una incidencia específica.
     */
    public function show($id)
    {
        $incidencia = Incidencia::with('archivo')->find($id);

        if (!$incidencia) {
            logger()->error('Incidencia no encontrada', ['id' => $id]);
            abort(404, 'Incidencia no encontrada');
        }

        // Obtener todas las incidencias paginadas
        $incidencias = Incidencia::orderBy('created_at', 'desc')->paginate(14);

        logger()->info('Incidencia encontrada:', $incidencia->toArray());

        return view('verIncidencia', compact('incidencia', 'incidencias'));
    }
    /**
     * Actualiza una incidencia existente.
     */
    public function update(Request $request, $id_incidencia)
    {
        // Validar los datos enviados
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|string',
            'prioridad' => 'required|string',
        ]);

        // Buscar y actualizar la incidencia
        $incidencia = Incidencia::findOrFail($id_incidencia);
        $incidencia->update($validatedData);

        return redirect()->route('incidencias.show', $id_incidencia)->with('success', 'Incidencia actualizada correctamente.');
    }

  // FUNCION PARA VER LOS MENSAJES
    public function mensajes()
    {
        return $this->hasMany(Mensaje::class, 'incidencia_id', 'id_incidencia');
    }

}
