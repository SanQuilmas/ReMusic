<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\Partitura;    
use App\Jobs\ProcessOemer;    
use App\Jobs\ProcessConvert;  
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;

class PartituraController extends Controller
{
    public function index()
    {
        $partituras = Partitura::all();

        return view('partituras.index', compact('partituras'));
    }

    public function create()
    {
        return view('partituras.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>'required',
            'imagen' => 'file|max:10240',
        ]);

        $file = $request->file('imagen');
        if($request->hasFile('imagen')){

            $filename = $file->getClientOriginalName();
            $folderName = 'imagenes/' . $request->get('nombre');
            
            // Crear carpeta 'data' para almacenar la imagen y el archivo musicxml
            $dataFolder = 'public/' . $folderName . '/data';
            \Storage::makeDirectory($dataFolder);
    
            // Guardar la imagen en la carpeta 'data'
            $imagePath = $file->storeAs($dataFolder, $filename);
    
            // Ruta del archivo musicxml dentro de 'data'
            $musicxmlPath = $dataFolder . '/' . pathinfo($filename, PATHINFO_FILENAME) . '.musicxml';
    
            // Crear subdirectorio 'midi' para almacenar el archivo midi
            $midiFolder = 'public/' . $folderName . '/midi';
            \Storage::makeDirectory($midiFolder);
    
            // Ruta del archivo midi dentro de 'midi'
            $midiPath = $midiFolder . '/' . pathinfo($filename, PATHINFO_FILENAME) . '.mid';

            $partitura = new Partitura([
                'nombre' => $request->get('nombre'),
                'image_path' => $imagePath,  // Imagen guardada en 'data'
                'musicxml_path' => $musicxmlPath,  // Archivo musicxml en 'data'
                'midi_path' => $midiPath,  // Archivo midi en 'midi'
            ]);

            $partitura->save();
            
//            try {
//                ProcessOemer::dispatch($partitura->id);
//            } catch (\Exception $e) {
//                \Log::error('Error in ProcessOemer: ' . $e->getMessage());
//            }

            Bus::chain([
                new ProcessOemer($partitura->id),
                new ProcessConvert($partitura->id),
            ])->catch(function (Throwable $e) {
                \Log::error('Error in job chain: ' . $e->getMessage());
            })->dispatch();

            return redirect('/partituras')->with('success', 'Partitura guardada!');
        }
        
        return redirect('/partituras')->with('error', 'Error al subir la partitura.');
    }

    public function show(string $id)
    {
        $partitura = Partitura::findOrFail($id);

//        try {
//            ProcessConvert::dispatch($partitura->id);
//        } catch (\Exception $e) {
//            \Log::error('Error in ProcessConvert: ' . $e->getMessage());
//        }

        return view('partituras.show', compact('partitura'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        $partitura = Partitura::find($id);
        $partitura->delete();

        return redirect('/partituras')->with('success', 'Partitura eliminada!');
    }

    public function getProgress($id)
    {
        $progress = Cache::get("progress_{$id}", 0); // Default to 0 if not found
        Log::info("Progress: {$progress}");
        return response()->json($progress);
    }

}