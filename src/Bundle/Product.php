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
 * Product
 *
 * @package   Parasut
 * @author    Sercan Çakır <srcnckr@gmail.com>
 * @license   MIT License
 * @copyright 2015
 */
class Product extends Bundle
{
    /**
     * Retrieve all products with pagination.
     *
     * @param  int  $page
     * @param  int  $limit
     * @return array
     */
    public function get($page = 1, $limit = 25)
    {
        return $this->client->call("products", [
            'page' => $page,
            'per_page' => $limit
        ], 'GET');
    }

    /**
     * Create a new product.
     *
     * @param  array  $params
     * @return array
     */
    public function create(array $params)
    {
        return $this->client->call("products", [
            'product' => $params
        ], 'POST');
    }

    /**
     * Retrieve a product informations via its own id.
     *
     * @param  int   $id
     * @return array
     */
    public function find($id)
    {
        return $this->client->call("products/{$id}", null, 'GET');
    }

    /**
     * Update the product with given arguments.
     *
     * @param  int    $id
     * @param  array  $params
     * @return array
     */
    public function update($id, array $params)
    {
        return $this->client->call("products/{$id}", [
            'product' => $params
        ], 'PUT');
    }

    /**
     * Delete an existing product.
     *
     * @param  int    $id
     * @return array
     */
    public function delete($id)
    {
        return $this->client->call("products/{$id}", null, 'DELETE');
    }
}
