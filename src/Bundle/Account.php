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
 * Account
 *
 * @package   Parasut
 * @author    Sercan Çakır <srcnckr@gmail.com>
 * @license   MIT License
 * @copyright 2015
 */
class Account extends Bundle
{
    /**
     * Retrieve all accounts with pagination.
     *
     * @param  int  $page
     * @param  int  $limit
     * @return array
     */
    public function get($page = 1, $limit = 25)
    {
        return $this->client->call("accounts", [
            'page' => $page,
            'per_page' => $limit
        ], 'GET');
    }

    /**
     * Retrieve an account informations.
     *
     * @param  int   $id
     * @param  bool  $transactions
     * @return array
     */
    public function find($id, $transactions = false)
    {
        return $this->client->call("accounts/{$id}", array_filter([
            'transactions' => $transactions
        ]), 'GET');
    }

    /**
     * Retrieve transactions of the account.
     *
     * @param  int    $id
     * @param  array  $params
     * @return array
     */
    public function transactions($id)
    {
        return $this->client->call("accounts/{$id}/transactions", null, 'GET');
    }
}
