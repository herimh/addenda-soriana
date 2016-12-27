<?php

namespace App\Http\Controllers\Admin;

use App\Models\Addenda;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\AddendaCrudRequest as StoreRequest;
use App\Http\Requests\AddendaCrudRequest as UpdateRequest;

class AddendaController extends CrudController
{
    public function setup() {
        $this->crud->setModel(Addenda::class);
        $this->crud->setRoute("admin/addenda");
        $this->crud->setEntityNameStrings('addenda', 'addendas');

        //$this->crud->addColumn();
        $this->crud->setColumns(['invoice']);
        $this->crud->setColumns(['consecutive']);
        $this->crud->addField([
            'name' => 'provider_code', 'label' => trans('label.provider_code'), 'type' => 'select_from_array' , 'options' => ['110437' => 'Florería Hortensia']
        ]);
        //Remision: Serie + Folio del CFDI
        //Consecutivo: 0
        $this->crud->addField([
            'name' => 'store_code', 'label' => trans('label.store_code')
        ]);
        $this->crud->addField([
            'name' => 'money_type', 'label' => trans('label.money_type'), 'type' => 'select_from_array' , 'options' => [1 => 'MXN', 2 => 'USD', 3 => 'EURO']
        ]);
        $this->crud->addField([
            'name' => 'package_type', 'label' => trans('label.package_type'), 'type' => 'select_from_array' , 'options' => [1 => 'Cajas', 2 => 'Bolsas']
        ]);
        $this->crud->addField([
            'name' => 'delivery_place', 'label' => trans('label.delivery_place'), 'type' => 'select_from_array' , 'options' => [1 => 'Tienda, Sucursal de Centros Comerciales o City Club', 2 => 'Cedis']
        ]);
        //CumpleReqFiscales: true
    }

    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }

    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }

}
