<?php

namespace App\Http\Lib;


use App\Http\Lib\CFDIXmlReader\CFDIXmlReader;

class FloreriaHortensiaCFDI
{

    private $cfdiArray = [];

    /**
     * FloreriaHortensiaCFDI constructor.
     * @param $file
     */
    public function __construct($file){
        $this->cfdiArray = CFDIXmlReader::getArrayFromFile($file);
    }

    public function getFolio(){
        return $this->cfdiArray['Comprobante']['@atributos']['folio'];
    }

    public function getSerie(){
        return $this->cfdiArray['Comprobante']['@atributos']['serie'];
    }

    public function getSubtotal(){
        return $this->cfdiArray['Comprobante']['@atributos']['subtotal'];
    }

    public function getDiscount(){
        return $this->cfdiArray['Comprobante']['@atributos']['descuento'];
    }

    public function getIEPS(){
        return '';//$this->cfdiArray['Comprobante']['@atributos']['descuento'];
    }

    public function getIVA(){
        return '';//$this->cfdiArray['Comprobante']['@atributos']['descuento'];
    }

    public function getTotal(){
        return $this->cfdiArray['Comprobante']['@atributos']['total'];
    }

    public function getSerieFolio(){
        return str_replace(' ', '', $this->getSerie().$this->getFolio());
    }

    public function getCreationDate(){
        return $this->cfdiArray['Comprobante']['@atributos']['fecha'];
    }

    public function getCfdiArray(){
        return $this->cfdiArray;
    }
}