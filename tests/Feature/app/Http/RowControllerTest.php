<?php

namespace Feature\app\Http;

use App\Models\Row;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RowControllerTest extends TestCase
{

    use RefreshDatabase;

    public function test_index()
    {
        Row::query()->create([
           'id' => 1,
           'name' => 'Row 1',
           'date' => '04.01.2025'
        ]);

        $rows = Row::all()->groupBy('date')->toJson();

        $this->getJson('api/rows')
            ->assertOk()
            ->assertContent($rows);
    }

}
