<?php

namespace App\Imports;

use App\Jobs\ImportJob;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FileImport implements ToCollection, WithChunkReading, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection): void
    {
        ImportJob::dispatch($collection);
    }


    public function chunkSize(): int
    {
        return 1000;
    }
}
