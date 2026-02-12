<?php

namespace Modules\Record\Infrastructure\Controllers;

use App\Http\Controllers\Controller;


class RecordController extends Controller
{
    public function index()
    {
        return view('record::index');
    }
}
