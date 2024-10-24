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

        while ($process->isRunning()) {
            // Optionally, here you can simulate updating progress, e.g. 50% done
            sleep(30); // Sleep to reduce server load
            Cache::put("progress_{$this->partituraId}", Cache::get("progress_{$this->partituraId}") + 5); // Simulated, change logic to track actual progress
        }

        // Check if the process failed
        if (!$process->isSuccessful()) {
            Log::error('Oemer process failed: ' . $process->getErrorOutput());
            throw new ProcessFailedException($process);
        }

        // Mark the progress as complete
        Cache::put("progress_{$this->partituraId}", 100);
    }
}