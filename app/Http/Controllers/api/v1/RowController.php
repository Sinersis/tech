<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Row;

class RowController extends Controller
{
    public function index()
    {
        return Row::query()->get()->groupBy('date');
    }
}
