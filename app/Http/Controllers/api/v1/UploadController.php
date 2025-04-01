<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadRequest;
use App\Imports\FileImport;
use App\Jobs\ImportJob;
use App\Jobs\ParseJob;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


class UploadController extends Controller
{
    public function upload(UploadRequest $request)
    {
        Redis::client()->del('increment');

        $file = $request->file('file')->storeAs('public', 'import.xlsx');

        ParseJob::dispatch(Storage::disk('local')->path($file));

        return response()->json(['status' => 'success']);
    }

}
