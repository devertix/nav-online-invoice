<?php

namespace NavOnlineInvoice\Abstracts;

use NavOnlineInvoice\Abstracts\Config;

abstract class InvoiceOperations
{
    const MAX_INVOICE_COUNT = 100;

    protected $invoices;

    protected $index;

    /**
     * @var Config
     */
    protected $config;

    protected $compressInvoices = false;

    /**
     * Számlákat (számla műveleteket) összefogó objektum (collection) készítése
     */
    public function __construct(\NavOnlineInvoice\Abstracts\Config $config)
    {
        $this->invoices = array();
        $this->index = 1;
        $this->config = $config;
    }

    abstract public function add(string $xml, $operation = "CREATE");

    public function getInvoices()
    {
        return $this->invoices;
    }

    public function enableCompression()
    {
        $this->compressInvoices = true;
    }

    public function isCompressionEnabled()
    {
        return $this->compressInvoices;
    }

    /**
     * XML objektum konvertálása base64-es szöveggé
     * @param string $xml
     * @return string
     */
    protected function convertXml(string $xml)
    {
        if ($this->compressInvoices) {
            $xml = gzencode($xml, 1);
        }
        return base64_encode($xml);
    }
}