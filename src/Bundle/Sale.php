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
class Sale extends Builder
{
    /**
     * Get all sale invoices with paginate.
     *
     * @param  int  $page
     * @param  int  $limit
     * @return array
     */
    public function get($page = 1, $limit = 25)
    {
        return $this->client->call("sales_invoices", [
            'page' => $page,
            'per_page' => $limit
        ], 'GET');
    }

    /**
     * Create a new sale invoice.
     *
     * @param  array  $params
     * @return array
     */
    public function create(array $params)
    {
        return $this->client->call("sales_invoices", [
            'sales_invoice' => $params
        ], 'POST');
    }

    /**
     * Retrieve a sale invoice informations by its own id.
     *
     * @param  int   $id
     * @return array
     */
    public function find($id)
    {
        return $this->client->call("sales_invoices/{$id}", null, 'GET');
    }

    /**
     * Update the existing sale invoice.
     *
     * @param  int    $id
     * @param  array  $params
     * @return array
     */
    public function update($id, array $params)
    {
        return $this->client->call("sales_invoices/{$id}", [
            'sales_invoice' => $params
        ], 'PUT');
    }

    /**
     * Convert estimate to invoice
     *
     * @param  int  $id
     * @return array
     */
    public function convertInvoice($id)
    {
        return $this->client->call("sales_invoices/{$id}/convert_to_invoice", null, 'POST');
    }

    /**
     * Delete the existing sale invoice.
     *
     * @param  int    $id
     * @return array
     */
    public function delete($id)
    {
        return $this->client->call("sales_invoices/{$id}", null, 'DELETE');
    }

    /**
     * Retrieve trashed sale invoices id.
     *
     * @param  string  $timestamp
     * @return array
     */
    public function trashed($timestamp)
    {
        return $this->client->call("sales_invoices/deleted_objects", array_filter([
            'last_synch' => $timestamp
        ]), 'GET');
    }
}
