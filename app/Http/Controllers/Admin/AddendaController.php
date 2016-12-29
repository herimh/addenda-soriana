<?php

namespace App\Http\Controllers\Admin;

use App\Http\Admin\AddendaTrait;
use App\Http\Lib\CFDIXmlReader\CFDIXmlReader;
use App\Models\Addenda;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\AddendaCrudRequest as StoreRequest;
use App\Http\Requests\AddendaCrudRequest as UpdateRequest;



class AddendaController extends CrudController
{
    use AddendaTrait;

    public function store(StoreRequest $request){
        return parent::storeCrud();
    }

    public function update(UpdateRequest $request){
        return parent::updateCrud();
    }

    /**
     * Show the form for creating inserting a new row.
     *
     * @return Response
     */
    public function create()
    {
        //$cfdiArray = CFDIXmlReader::getArrayFromDir(storage_path('facturas_soriana/cfdi_temp/'));

        //dd($cfdiArray[0]);
        return parent::create();
    }

}
