<?php

namespace App\Jobs;

use App\Imports\FileImport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Maatwebsite\Excel\Facades\Excel;

class ParseJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected string $filepath)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Excel::import(
            import: new FileImport,
            filePath: $this->filepath,
            readerType: \Maatwebsite\Excel\Excel::XLSX
        );
    }
}
