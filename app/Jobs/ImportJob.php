<?php

namespace App\Jobs;

use App\Models\Row;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ImportJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Collection $chunk)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        if (empty(Redis::client()->get('increment'))) {
            Redis::client()->set('increment', 1);
        }

        foreach ($this->chunk as $row) {
            $increment = Redis::client()->get('increment');

            $validator = Validator::make($row->toArray(), [
                'id' => ['required', 'unique:rows,id', 'integer', 'min:1'],
                'name' => ['required', 'regex:/^[A-Za-z ]+$/'],
                'date' => ['required', 'date', 'date_format:d.m.Y'],
            ]);

            if ($validator->fails() && $validator->errors()->count() > 0) {
                Log::channel('import')->debug(
                    "Row $increment failed validation: ". implode(', ', $validator->errors()->all())
                );

                Redis::client()->incr('increment');
                continue;
            }

            if (Row::query()->firstOrCreate($validator->validate())) {
                Redis::client()->incr('increment');
            }

        }
    }
}
