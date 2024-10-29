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

class ProcessConvert implements ShouldQueue
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
        $scriptPath = base_path('storage/convert.py');
        $inputPath = dirname(storage_path('app/' . $partitura->musicxml_path));
        $outputPath = dirname(storage_path('app/' . $partitura->midi_path));
        $midiFilePath = storage_path('app/' . $partitura->midi_path);

        Log::info("Input Path: {$inputPath}");
        Log::info("Output Path: {$outputPath}");

        if (file_exists($midiFilePath)) {
            Log::info("El archivo MIDI ya existe en: {$midiFilePath}. Proceso de conversión omitido.");
            Cache::put("progress_{$this->partituraId}", 100);
            return; // Si ya existe, no ejecutar el proceso
        }

        Log::info("El archivo MIDI no existe. Iniciando proceso de conversión...");

        $process = new Process(['python', $scriptPath, $inputPath, $outputPath]);
        $process->setTimeout(null);
        
        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                Log::error('Error Output: ' . $buffer);
            } else {
                Log::info('Output: ' . $buffer);
            }
        });

        // Check if the process failed
        if (!$process->isSuccessful()) {
            Log::error('Midi-Convert process failed: ' . $process->getErrorOutput());
            throw new ProcessFailedException($process);
        }

        Cache::put("progress_{$this->partituraId}", 100);

    }
}
