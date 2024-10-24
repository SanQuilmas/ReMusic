<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\Partitura;    
use App\Jobs\ProcessOemer;    
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PartituraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partituras = Partitura::all();

        return view('partituras.index', compact('partituras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('partituras.create');
    }

    /**
     * Store a newly created resource in storage.
     */
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
            $path = $file->storeAs('public/' . $folderName, $filename);
        
            $imagenPath = storage_path('app/' . $path);
            $outputPath = storage_path('app/public/' . $folderName . '/' . pathinfo($filename, PATHINFO_FILENAME) . '.musicxml');

            $partitura = new Partitura([
                'nombre' => $request->get('nombre'),
                'image_path' => $path,
                'musicxml_path' =>  'public/' . $folderName . '/' . pathinfo($filename, PATHINFO_FILENAME) . '.musicxml',
            ]);

            $partitura->save();
            
            try {
                ProcessOemer::dispatch($partitura->id);
            } catch (\Exception $e) {
                \Log::error('Error in ProcessOemer: ' . $e->getMessage());
            }

            return redirect('/partituras')->with('success', 'Partitura guardada!');
        }
        
        return redirect('/partituras')->with('error', 'Error al subir la partitura.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscar la partitura por ID
        $partitura = Partitura::findOrFail($id);

        // Pasar la partitura a la vista
        return view('partituras.show', compact('partitura'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
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