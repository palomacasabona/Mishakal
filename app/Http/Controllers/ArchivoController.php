<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class ArchivoController extends Controller
{
    /**
     * Muestra una lista de todos los archivos.
     */
    public function index()
    {
        // Obtiene todos los archivos de la base de datos
        $archivos = Archivo::all();
        // Retorna la vista 'archivos.index' con los datos de los archivos
        return view('archivos.index', compact('archivos'));
    }

    /**
     * Muestra el formulario para subir un nuevo archivo.
     */
    public function create()
    {
        // Retorna la vista 'archivos.create' para mostrar el formulario
        return view('archivos.create');
    }

    /**
     * Almacena un archivo en el sistema y registra su información en la base de datos.
     */
    public function store(Request $request)
    {
        // Valida los datos del formulario y el archivo
        $validated = $request->validate([
            'nombre' => 'required|string|max:255', // Nombre del archivo es obligatorio
            'archivo' => 'required|file|max:2048', // El archivo es obligatorio y no puede exceder 2 MB
            'incidencia_id' => 'required|exists:incidencias,id_incidencia', // ID de la incidencia debe existir
        ]);

        // Guarda el archivo en el almacenamiento local (carpeta 'archivos')
        $rutaArchivo = $request->file('archivo')->store('archivos', 'public');

        // Crea el registro en la base de datos
        Archivo::create([
            'nombre' => $validated['nombre'],
            'ruta_archivo' => $rutaArchivo, // Ajustado para coincidir con el campo en la base de datos
            'incidencia_id' => $validated['incidencia_id'],
        ]);

        // Redirige a la lista de archivos con un mensaje de éxito
        return redirect()->route('archivos.index')->with('success', 'Archivo subido exitosamente.');
    }

    /**
     * Muestra los detalles de un archivo específico.
     */
    public function show($id)
    {
        // Busca el archivo por su ID
        $archivo = Archivo::findOrFail($id);

        // Retorna la vista 'archivos.show' con los datos del archivo
        return view('archivos.show', compact('archivo'));
    }

    /**
     * Descarga un archivo del sistema.
     */
    public function download($id)
    {
        // Busca el archivo por su ID
        $archivo = Archivo::findOrFail($id);

        // Retorna el archivo para su descarga
        return Storage::download($archivo->ruta_archivo, $archivo->nombre);
    }

    /**
     * Elimina un archivo del sistema y de la base de datos.
     */
    public function destroy($id)
    {
        // Busca el archivo por su ID
        $archivo = Archivo::findOrFail($id);

        // Elimina el archivo del sistema de almacenamiento
        Storage::delete($archivo->ruta_archivo);

        // Elimina el registro de la base de datos
        $archivo->delete();

        // Redirige a la lista de archivos con un mensaje de éxito
        return redirect()->route('archivos.index')->with('success', 'Archivo eliminado exitosamente.');
    }
}
