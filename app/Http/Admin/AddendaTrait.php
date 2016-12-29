<?php
namespace App\Http\Admin;

/**
 * El trait unicamente funciona hereado en el AddendaController
 */

use App\Models\Addenda;

trait AddendaTrait
{

    public function setup() {
        $this->crud->setModel(Addenda::class);
        $this->crud->setRoute("admin/addenda");
        $this->crud->setEntityNameStrings('addenda', 'addendas');

        //LIST FIELDS
        $this->crud->setColumns(['invoice']);
        $this->crud->setColumns(['consecutive']);

        //CREATE AND EDIT FIELDS
        $this->crud->addField([
            'name' => 'provider_code', 'label' => trans('label.provider_code'), 'type' => 'select_from_array' ,
            'options' => ['110437' => 'Florería Hortensia'],
        ]);

        $this->crud->addField([
            'name' => 'delivery_place', 'label' => trans('label.delivery_place'), 'type' => 'select_from_array' ,
            'options' => [1 => 'Tienda, Sucursal de Centros Comerciales o City Club', 2 => 'Cedis'],
            'wrapperAttributes' => ['class' => 'form-group col-md-6']
        ]);

        $this->crud->addField([
            'name' => 'store_code', 'label' => trans('label.store_code'),
            'wrapperAttributes' => ['class' => 'form-group col-md-3']
        ]);

        $this->crud->addField([
            'name' => 'delivery_date', 'label' => trans('label.delivery_date'), 'type' => 'date_picker',
            'wrapperAttributes' => ['class' => 'form-group col-md-3'],
            'date_picker_options' => [
                'todayBtn' => true,
                'format' => 'yyyy-mm-dd',
                'language' => 'es'
            ],
        ]);

        $this->crud->addField([
            'name' => 'delivery_folio', 'label' => trans('label.delivery_folio'),
            'wrapperAttributes' => ['class' => 'form-group col-md-3']
        ]);

        $this->crud->addField([
            'name' => 'package_type', 'label' => trans('label.package_type'), 'type' => 'select_from_array' ,
            'options' => [1 => 'Cajas', 2 => 'Bolsas'],
            'wrapperAttributes' => ['class' => 'form-group col-md-3']
        ]);
        $this->crud->addField([
            'name' => 'package_quantity', 'label' => trans('label.package_quantity'), 'type' => 'number',
            'wrapperAttributes' => ['class' => 'form-group col-md-3']
        ]);

        //Remision: Serie + Folio del CFDI
        //Consecutivo: 0

        $this->crud->addField([
            'name' => 'money_type', 'label' => trans('label.money_type'), 'type' => 'select_from_array' ,
            'options' => [1 => 'MXN', 2 => 'USD', 3 => 'EURO'],
            'wrapperAttributes' => ['class' => 'form-group col-md-3']
        ]);


        $this->crud->addField([
            'name' => 'purchase_order', 'label' => trans('label.purchase_order'),
            'wrapperAttributes' => ['class' => 'form-group col-md-3']
        ]);

        $this->crud->addField([
            'name' => 'cfdi_file', 'label' => trans('label.cfdi_file'), 'type' => 'upload', 'upload' => true,
            'disk' => 'public', // if you store files in the /public folder, please ommit this; if you store them in /storage or S3, please specify it;
            'wrapperAttributes' => ['class' => 'form-group col-md-6']
        ]);



        //CumpleReqFiscales: true
        //PedidoEmitidoProveedor: SI


    }

}