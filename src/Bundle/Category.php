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
 * Category
 *
 * @package   Parasut
 * @author    Sercan Çakır <srcnckr@gmail.com>
 * @license   MIT License
 * @copyright 2015
 */
class Category extends Bundle
{
    /**
     * Retrieve all categories with pagination.
     *
     * @param  int  $page
     * @param  int  $limit
     * @return array
     */
    public function get($page = 1, $limit = 25)
    {
        return $this->client->call("item_categories", [
            'page' => $page,
            'per_page' => $limit
        ], 'GET');
    }

    /**
     * Create a new category.
     *
     * @param  array  $params
     * @return array
     */
    public function create(array $params)
    {
        return $this->client->call("item_categories", [
            'item_category' => $params
        ], 'POST');
    }

    /**
     * Retrieve a category informations via its own id.
     *
     * @param  int   $id
     * @return array
     */
    public function find($id)
    {
        return $this->client->call("item_categories/{$id}", null, 'GET');
    }

    /**
     * Update the category with given arguments.
     *
     * @param  int    $id
     * @param  array  $params
     * @return array
     */
    public function update($id, array $params)
    {
        return $this->client->call("item_categories/{$id}", [
            'item_category' => $params
        ], 'PUT');
    }

    /**
     * Delete an existing category.
     *
     * @param  int    $id
     * @return array
     */
    public function delete($id)
    {
        return $this->client->call("item_categories/{$id}", null, 'DELETE');
    }
}
