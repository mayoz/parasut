<?php

/*
 * This file is part of Parasut.
 *
 * (c) Sercan Çakır <srcnckr@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Parasut\Bundle;

use Parasut\Bundle;

/**
 * Sale
 *
 * @package   Parasut
 * @author    Sercan Çakır <srcnckr@gmail.com>
 * @license   MIT License
 * @copyright 2015
 */
class Sale extends Bundle
{
    /**
     * Retrieve all sales invoices with pagination.
     *
     * @param  int  $page
     * @param  int  $limit
     * @param  string|null  $lastSynch
     * @return array
     */
    public function get($page = 1, $limit = 25, $lastSynch = null)
    {
        return $this->client->call("sales_invoices", [
            'page' => $page,
            'per_page' => $limit,
            'last_synch' => $lastSynch,
        ], 'GET');
    }

    /**
     * Create a new sales invoice.
     *
     * @param  array  $params
     * @return array
     */
    public function create(array $params)
    {
        return $this->client->call("sales_invoices", [
            'sales_invoice' => $params,
        ], 'POST');
    }

    /**
     * Retrieve a sales invoice informations via its own id.
     *
     * @param  int   $id
     * @return array
     */
    public function find($id)
    {
        return $this->client->call("sales_invoices/{$id}", null, 'GET');
    }

    /**
     * Update the sales invoice with given arguments.
     *
     * @param  int    $id
     * @param  array  $params
     * @return array
     */
    public function update($id, array $params)
    {
        return $this->client->call("sales_invoices/{$id}", [
            'sales_invoice' => $params,
        ], 'PUT');
    }

    /**
     * Marked paid the sales invoice with given arguments.
     *
     * @param  int    $id
     * @param  array  $params
     * @return array
     */
    public function paid($id, array $params)
    {
        return $this->client->call("sales_invoices/{$id}/payments", [
            'payment' => $params,
        ], 'POST');
    }

    /**
     * Convert estimate to invoice.
     *
     * @param  int  $id
     * @return array
     */
    public function convertInvoice($id)
    {
        return $this->client->call("sales_invoices/{$id}/convert_to_invoice", null, 'POST');
    }

    /**
     * Delete an existing sales invoice.
     *
     * @param  int    $id
     * @return array
     */
    public function delete($id)
    {
        return $this->client->call("sales_invoices/{$id}", null, 'DELETE');
    }

    /**
     * Retrieve the trashed sales invoices ids.
     *
     * @param  string  $timestamp
     * @return array
     */
    public function trashed($timestamp)
    {
        return $this->client->call("sales_invoices/deleted_objects", array_filter([
            'last_synch' => $timestamp,
        ]), 'GET');
    }

    /**
     * Create a new e-invoice record.
     *
     * @param  int    $id
     * @param  array  $params
     * @return array
    */
    public function createEInvoice($id, array $params)
    {
        return $this->client->call("sales_invoices/{$id}/e_invoice", [
            'e_invoice' => $params,
        ], 'POST');
    }

    /**
     * Create a new e-archive record.
     *
     * @param  int    $id
     * @param  array  $params
     * @return array
    */
    public function createEArchive($id, array $params)
    {
        return $this->client->call("sales_invoices/{$id}/e_archive", [
            'e_archive' => $params,
        ], 'POST');
    }
    
    /**
     * Retrieve the e-invoice's document type.
     *
     * @param  int  $id
     * @return array
    */
    public function getEInvoiceType($id)
    {
        return $this->client->call("sales_invoices/{$id}/e_document_type", null, 'GET');
    }

    /**
     * Retrieve the invoice's document status.
     *
     * @param  int  $id
     * @return array
    */
    public function getEInvoiceStatus($id)
    {
        return $this->client->call("sales_invoices/{$id}/e_document_status", null, 'GET');
    }
    
    /**
     * Retrieve the e-invoice's inbox details.
     *
     * @param  string  $vatId
     * @return array
    */
    public function getEInvoiceInboxes($taxNumber)
    {
        return $this->client->call("e_invoice_inboxes",[
            'vkn' => $taxNumber,
        ], 'GET');
    }
}
