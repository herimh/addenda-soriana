<?php

namespace App\Http\Controllers\Admin;

use App\Http\Admin\AddendaTrait;
use App\Http\Lib\CFDIXmlReader\CFDIXmlReader;
use App\Http\Lib\FloreriaHortensiaCFDI;
use App\Models\Addenda;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\AddendaCrudRequest as StoreRequest;
use App\Http\Requests\AddendaCrudRequest as UpdateRequest;



class AddendaController extends CrudController
{
    use AddendaTrait;

    public function store(StoreRequest $request){

        $this->crud->hasAccessOrFail('create');

        // fallback to global request instance
        if (is_null($request)) {
            $request = \Request::instance();
        }

        // replace empty values with NULL, so that it will work with MySQL strict mode on
        foreach ($request->input() as $key => $value) {
            if (empty($value) && $value !== '0') {
                $request->request->set($key, null);
            }
        }

        // insert item in the db
        $item = $this->crud->create($request->except(['redirect_after_save', '_token']));
        $this->data['entry'] = $this->crud->entry = $item;

        //OVERWRITTEN
        if($item){
            $cfdi = new FloreriaHortensiaCFDI(storage_path('facturas_soriana/').$item->cfdi_file);
            $item->invoice = $cfdi->getSerieFolio();
            $item->save();
        }

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // redirect the user where he chose to be redirected
        switch ($request->input('redirect_after_save')) {
            case 'current_item_edit':
                return \Redirect::to($this->crud->route.'/'.$item->getKey().'/edit');

            default:
                return \Redirect::to($request->input('redirect_after_save'));
        }
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
