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

        $this->crud->setColumns(['invoice']);
        $this->crud->setColumns(['consecutive']);
        $this->crud->addField([
            'name' => 'invoice',
            'label' => "Invoice"
        ]);
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
