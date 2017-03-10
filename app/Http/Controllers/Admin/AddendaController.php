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
use PhpParser\Serializer\XML;


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
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $this->crud->hasAccessOrFail('update');

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['fields'] = $this->crud->getUpdateFields($id);
        $this->data['title'] = trans('backpack::crud.edit').' '.$this->crud->entity_name;

        $this->data['id'] = $id;

        //TODO: boorame
        $addenda = Addenda::find($id);
        $cfdi = new  FloreriaHortensiaCFDI(storage_path('facturas_soriana/').$addenda->cfdi_file);

        dump($this->getAddendaXml($addenda));

        dd($cfdi->getCfdiArray());

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('admin.addenda.edit', $this->data);
    }

    private function getAddendaXml(Addenda $addenda)
    {
        $cfdi = new FloreriaHortensiaCFDI(storage_path('facturas_soriana/').$addenda->cfdi_file);

        $cfdiArray = $cfdi->getCfdiArray();

        $remision = <<<XML
<Remision Id="Remision1" RowOrder="0">
            <Proveedor>{$addenda->provider_code}</Proveedor>
            <Remision>{$addenda->invoice}</Remision>
            <Consecutive>0</Consecutive>
            <FechaRemision>{$cfdi->getCreationDate()}</FechaRemision>
            <Tienda>{$addenda->store_code}</Tienda>
            <TipoMoneda>{$addenda->money_type}</TipoMoneda>
            <TipoBulto>{$addenda->package_type}</TipoBulto>
            <EntregaMercancia> .... </EntregaMercancia>
            <CumpleReqFiscales>true</CumpleReqFiscales>
            <CantidadBultos>{$addenda->package_quantity}</CantidadBultos>
            <Subtotal>{$cfdi->getSubtotal()}</Subtotal>
            <Descuentos>{$cfdi->getDiscount()}</Descuentos>
            <IEPS>{$cfdi->getIEPS()}</IEPS>
            <IVA>{$cfdi->getIVA()}</IVA>
            <OtrosImpuestos>0.00</OtrosImpuestos>
            <Total>{$cfdi->getTotal()}</Total>
            <CantidadPedidos>1</CantidadPedidos>
            <FechaEntregaMercancia>{$addenda->delivery_date}</FechaEntregaMercancia>
            <Cita> ... </Cita>
        </Remision>
XML;


        $pedidos = <<<XML
<Pedidos Id="Pedido1" RowOrder="1">
            <Proveedor>{$addenda->provider_code}</Proveedor> 
            <Remision>{$addenda->invoice}</Remision> 
            <FolioPedido>....</FolioPedido> 
            <Tienda>{$addenda->store_code}</Tienda> 
            <CantidadArticulos>{$cfdi->getProductsCount()}</CantidadArticulos>
        </Pedidos>
XML;

        $articulos = '';
        foreach ($cfdi->getOrderProducts() as $index => $product){
            $articulos.= <<<XML
<Articulos Id="Articulos{($index+1)}" RowOrder="1">
				<Proveedor>{$addenda->provider_code}</Proveedor> 
				<Remision>{$addenda->invoice}</Remision> 
				<FolioPedido>....</FolioPedido> 
				<Tienda>{$addenda->store_code}</Tienda> 
				<Codigo>{$product["noIdentificacion"]}</Codigo> 
				<CantidadUnidadCompra>{$product["cantidad"]}</CantidadUnidadCompra> 
				<CostoNetoUnidadCompra>{$product["valorUnitario"]}</CostoNetoUnidadCompra> 
				<PorcentajeIEPS>0.00</PorcentajeIEPS> 
				<PorcentajeIVA>0.00</PorcentajeIVA> 
			</Articulos>
XML;
        }

        $xml = <<<XML
<cfdi:Addenda>
    <DSCargaRemisionProv>
        {$remision}
        {$pedidos}
        {$articulos}
    </DSCargaRemisionProv>
</cfdi:Addenda>
XML;




        return $xml;
    }
}
