<?php

namespace Inodata\InvoicerBundle\Lib;

/**
 *
 * @author Heriberto Monterrubio <heri185403@gmail.com>
 */
class YahooAcount extends BaseAcount
{   
    //@TODO: Define imap connection with Yahoo accounts
    
    public function getCFDIsFromUnseen()
    {
        //@TODO: read new emnails using imap and find CFDIs
        return null;
    }
}
