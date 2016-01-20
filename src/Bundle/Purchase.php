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
 * Purchase
 *
 * @package   Parasut
 * @author    Sercan Çakır <srcnckr@gmail.com>
 * @license   MIT License
 * @copyright 2015
 */
class Purchase extends Bundle
{
    /**
     * Retrieve all purchase invoices with pagination.
     *
     * @param  int  $page
     * @param  int  $limit
     * @return array
     */
    public function get($page = 1, $limit = 25)
    {
        return $this->client->call("purchase_invoices", [
            'page' => $page,
            'per_page' => $limit
        ], 'GET');
    }

    /**
     * Create a new purchase invoice.
     *
     * @param  array  $params
     * @return array
     */
    public function create(array $params)
    {
        return $this->client->call("purchase_invoices", [
            'purchase_invoice' => $params
        ], 'POST');
    }

    /**
     * Retrieve a purchase invoice informations via its own id.
     *
     * @param  int   $id
     * @return array
     */
    public function find($id)
    {
        return $this->client->call("purchase_invoices/{$id}", null, 'GET');
    }

    /**
     * Update the purchase invoice with given arguments.
     *
     * @param  int    $id
     * @param  array  $params
     * @return array
     */
    public function update($id, array $params)
    {
        return $this->client->call("purchase_invoices/{$id}", [
            'purchase_invoice' => $params
        ], 'PUT');
    }

    /**
     * Marked paid the purchase invoice with given arguments.
     *
     * @param  int    $id
     * @param  array  $params
     * @return array
     */
    public function paid($id, array $params)
    {
        return $this->client->call("purchase_invoices/{$id}/payments", [
            'payment' => $params
        ], 'POST');
    }

    /**
     * Convert estimate to invoice
     *
     * @param  int  $id
     * @return array
     */
    public function convertInvoice($id)
    {
        return $this->client->call("purchase_invoices/{$id}/convert_to_invoice", null, 'POST');
    }

    /**
     * Delete an existing purchase invoice.
     *
     * @param  int    $id
     * @return array
     */
    public function delete($id)
    {
        return $this->client->call("purchase_invoices/{$id}", null, 'DELETE');
    }

    /**
     * Retrieve the trashed purchase invoices ids.
     *
     * @param  string  $timestamp
     * @return array
     */
    public function trashed($timestamp)
    {
        return $this->client->call("purchase_invoices/deleted_objects", array_filter([
            'last_synch' => $timestamp
        ]), 'GET');
    }
}
