<?php

namespace Feature\app\Http;

use App\Jobs\ParseJob;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class UploadControllerTest extends TestCase
{

    public function test_upload_success()
    {
        Excel::fake();
        Queue::fake();

        $this->postJson('/api/upload', ['file' => UploadedFile::fake()->create('import.xlsx')])
            ->assertStatus(200);
    }


    public function test_upload_fail()
    {
        $file = UploadedFile::fake()->create('import.csv');

        $this->postJson('/api/upload', ['file' => $file])
            ->assertStatus(422);
    }

}
