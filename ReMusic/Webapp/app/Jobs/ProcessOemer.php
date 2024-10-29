<?php

namespace App\Jobs;

use App\Models\Partitura; 
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Cache; 

class ProcessOemer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $partituraId;

    public function __construct($partituraId)
    {
        $this->partituraId = $partituraId;
    }

    public function handle()
    {
        $partitura = Partitura::find($this->partituraId);
        $imagenPath = storage_path('app/' . $partitura->image_path);
        $outputPath = dirname(storage_path('app/' . $partitura->musicxml_path));

        Log::info("Oemer Input Path: {$imagenPath}");
        Log::info("Oemer Output Path: {$outputPath}");

        if (file_exists((storage_path('app/' . $partitura->musicxml_path)))) {
            Log::info("El archivo MusicXML ya existe en: {(storage_path('app/' . $partitura->musicxml_path))}. Proceso de conversión omitido.");
            Cache::put("progress_{$this->partituraId}", 96);
            return; // Si ya existe, no ejecutar el proceso
        }

        // Execute the 'oemer' command
        $process = new Process(['oemer', '-o', $outputPath, $imagenPath]);
        $process->setTimeout(null); // No timeout
        
        Cache::put("progress_{$this->partituraId}", 1);

        //$process->start();

        $progress = 0; //Max Progress 96% porque el proceso oemer es el 96% del tiempo de guardado aproximadamente
        $counter = 12;

        $process->run(function ($type, $buffer) use (&$progress, &$counter) {
            if (Process::ERR === $type) {
                Log::error('Oemer Error Output: ' . $buffer);
            } else {
                Log::info('Oemer Output: ' . $buffer);
            }

            if($counter > 0){
                $progressTick = 6.9;
                $counter = $counter - 1;
            }else {
                $progressTick = 0.1;
            }

            $progress = $progress + $progressTick;
            Cache::put("progress_{$this->partituraId}", $progress);

        });

        // Check if the process failed
        if (!$process->isSuccessful()) {
            Log::error('Oemer process failed: ' . $process->getErrorOutput());
            // Borrar la partitura si falla el proceso
            $this->deletePartitura();
            throw new ProcessFailedException($process);
        } 

        Cache::put("progress_{$this->partituraId}", 96);
    }

    private function deletePartitura()
    {
        $partitura = Partitura::find($this->partituraId);

        if ($partitura) {
            $partitura->delete();
            Log::info("Partitura con ID {$this->partituraId} eliminada debido a fallo en el proceso.");
        }
    }
    
}