<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Addenda extends Model
{
    use CrudTrait;

    protected $fillable = ['provider_code', 'invoice', 'consecutive', 'store_code', 'money_type', 'package_type', 'package_quantity',
        'delivery_place', 'delivery_date', 'delivery_folio', 'cite', 'purchase_order', 'cfdi_file', 'addenda_file'];

    public function setCfdiFileAttribute($value)
    {
        $attribute_name = "cfdi_file";
        $disk = "fsoriana";
        $destination_path = "cfdis_originales";

        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
    }
}
