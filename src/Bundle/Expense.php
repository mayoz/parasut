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
class Expense extends Builder
{
    /**
     * Get all expenses with paginate.
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
     * Get all expenses by paginate with spesific month of the year.
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
     * Retrieve a expense informations by its own id.
     *
     * @param  int   $id
     * @return array
     */
    public function find($id)
    {
        return $this->client->call("expenses/{$id}", null, 'GET');
    }

    /**
     * Update the existing expense.
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
     * Delete the existing expense.
     *
     * @param  int    $id
     * @return array
     */
    public function delete($id)
    {
        return $this->client->call("expenses/{$id}", null, 'DELETE');
    }

    /**
     * Retrieve trashed expenses id.
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
