<?php

namespace App\Http\Controllers\Legacy;

use App\Http\Admin\AddendaTrait;
use App\Http\Lib\CFDIXmlReader\CFDIXmlReader;
use App\Http\Lib\FloreriaHortensiaCFDI;
use App\Models\Addenda;
use App\Models\Flower;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\AddendaCrudRequest as StoreRequest;
use App\Http\Requests\AddendaCrudRequest as UpdateRequest;
use PhpParser\Serializer\XML;


class FlowerController extends CrudController
{
    public function index()
    {
        return view('legacy.list')->with('flowers', Flower::all());
    }
}
