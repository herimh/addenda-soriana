<?php
/**
 * Created by PhpStorm.
 * User: heriberto
 * Date: 4/01/17
 * Time: 02:39 PM
 */

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

    public function getSerieFolio(){
        return str_replace(' ', '', $this->getSerie().$this->getFolio());
    }
}