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
 * Contact
 *
 * @package   Parasut
 * @author    Sercan Çakır <srcnckr@gmail.com>
 * @license   MIT License
 * @copyright 2015
 */
class Contact extends Bundle
{
    /**
     * Retrieve all contacts with pagination.
     *
     * @param  int  $page
     * @param  int  $limit
     * @return array
     */
    public function get($page = 1, $limit = 25)
    {
        return $this->client->call("contacts", [
            'page' => $page,
            'per_page' => $limit
        ], 'GET');
    }

    /**
     * Create a new contact.
     *
     * @param  array  $params
     * @return array
     */
    public function create(array $params)
    {
        return $this->client->call("contacts", [
            'contact' => $params
        ], 'POST');
    }

    /**
     * Retrieve a contact informations via its own id.
     *
     * @param  int   $id
     * @param  bool  $payments
     * @param  bool  $transactions
     * @param  bool  $stats
     * @return array
     */
    public function find($id, $payments = false, $transactions = false, $stats = false)
    {
        return $this->client->call("contacts/{$id}", array_filter([
            'outstanding_payments' => $payments,
            'past_transactions' => $transactions,
            'stats' => $stats
        ]), 'GET');
    }

    /**
     * Update the contact with given arguments.
     *
     * @param  int    $id
     * @param  array  $params
     * @return array
     */
    public function update($id, array $params)
    {
        return $this->client->call("contacts/{$id}", [
            'contact' => $params
        ], 'PUT');
    }

    /**
     * Delete an existing contact.
     *
     * @param  int    $id
     * @return array
     */
    public function delete($id)
    {
        return $this->client->call("contacts/{$id}", null, 'DELETE');
    }
}
