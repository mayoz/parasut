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
 * Expense
 *
 * @package   Parasut
 * @author    Sercan Çakır <srcnckr@gmail.com>
 * @license   MIT License
 * @copyright 2015
 */
class Expense extends Bundle
{
    /**
     * Retrieve all expenses with pagination.
     *
     * @param  int  $page
     * @param  int  $limit
     * @return array
     */
    public function get($page = 1, $limit = 25)
    {
        return $this->client->call("expenses", [
            'page' => $page,
            'per_page' => $limit
        ], 'GET');
    }

    /**
     * Retrieve all expenses by pagination with spesific month of the year.
     *
     * @param  int  $year
     * @param  int  $month
     * @param  int  $page
     * @param  int  $limit
     * @return array
     */
    public function monthly($year, $month, $page = 1, $limit = 25)
    {
        return $this->client->call("expenses/in_month/{$year}/{$month}", [
            'page' => $page,
            'per_page' => $limit
        ], 'GET');
    }

    /**
     * Create a new expense.
     *
     * @param  array  $params
     * @return array
     */
    public function create(array $params)
    {
        return $this->client->call("expenses", [
            'expense' => $params
        ], 'POST');
    }

    /**
     * Retrieve a expense informations via its own id.
     *
     * @param  int   $id
     * @return array
     */
    public function find($id)
    {
        return $this->client->call("expenses/{$id}", null, 'GET');
    }

    /**
     * Update the expense with given arguments.
     *
     * @param  int    $id
     * @param  array  $params
     * @return array
     */
    public function update($id, array $params)
    {
        return $this->client->call("expenses/{$id}", [
            'expense' => $params
        ], 'PUT');
    }

    /**
     * Delete an existing expense.
     *
     * @param  int    $id
     * @return array
     */
    public function delete($id)
    {
        return $this->client->call("expenses/{$id}", null, 'DELETE');
    }

    /**
     * Retrieve the trashed expenses ids.
     *
     * @param  string  $timestamp
     * @return array
     */
    public function trashed($timestamp)
    {
        return $this->client->call("expenses/deleted_objects", array_filter([
            'last_synch' => $timestamp
        ]), 'GET');
    }
}
