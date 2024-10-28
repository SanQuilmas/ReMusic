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
        $outputPath = storage_path('app/' . $partitura->musicxml_path);

        Log::info("Image Path: {$imagenPath}");
        Log::info("Output Path: {$outputPath}");

        // Execute the 'oemer' command
        $process = new Process(['oemer', '-o', $outputPath, $imagenPath]);
        $process->setTimeout(null); // No timeout
        
        // Set initial progress to 0
        Cache::put("progress_{$this->partituraId}", 1);

        // Simulate progress (you can update this with actual progress if possible)
        $process->start();

        $max_progress = 60;
        $progress = 0;

        while ($process->isRunning()) {
            // Optionally, here you can simulate updating progress, e.g. 50% done
            sleep(30); // Sleep to reduce server load
            $progress = $progress + 5;
            Cache::put("progress_{$this->partituraId}", $progress);
            if($progress >= $max_progress){
                break;
            }
        }

        // Check if the process failed
        if (!$process->isSuccessful()) {
            Log::error('Oemer process failed: ' . $process->getErrorOutput());
            // Borrar la partitura si falla el proceso
            $this->deletePartitura();
            throw new ProcessFailedException($process);
        }

        Cache::put("progress_{$this->partituraId}", 75);
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