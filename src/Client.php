<?php

/*
 * This file is part of Parasut.
 *
 * (c) Sercan Çakır <srcnckr@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Parasut;

use Parasut\Exception\UnauthorizedException;
use Parasut\Exception\NotFoundException;
use Parasut\Exception\UnprocessableEntityException;
use Parasut\Exception\InternalServerErrorException;

/**
 * Client
 *
 * @package   Parasut
 * @author    Sercan Çakır <srcnckr@gmail.com>
 * @license   MIT License
 * @copyright 2015
 */
class Client
{
    /**
     * The API base URL.
     *
     * @return string
     */
    const API_URL = 'https://api.parasut.com/v1';

    /**
     * The OAuth token URL.
     *
     * @var string
     */
    const API_TOKEN_URL = 'https://api.parasut.com/oauth/token';

    /**
     * The related company id.
     *
     * @var int
     */
    protected $id;

    /**
     * The list of bundles.
     *
     * @var array
     */
    protected $bundles = [
        'account'  => '\Parasut\Bundle\Account',
        'category' => '\Parasut\Bundle\Category',
        'contact'  => '\Parasut\Bundle\Contact',
        'expense'  => '\Parasut\Bundle\Expense',
        'product'  => '\Parasut\Bundle\Product',
        'purchase' => '\Parasut\Bundle\Purchase',
    ];

    /**
     * The list of resolved bundles.
     *
     * @var array
     */
    protected $resolved = [];

    /**
     * Constructor.
     *
     * @param  int  $id
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Generate the api url.
     *
     * @param  string  $prefix
     * @param  bool  $includeId
     * @return string
     */
    public function apiUrl($prefix = null)
    {
        return implode(array_filter([
            self::API_URL, $this->getId(), trim($prefix, '/')
        ]), '/');
    }

    /**
     * Send a new authorization request.
     *
     * @param  string  $token
     * @return $this
     */
    public function authorize(array $config)
    {
        $response = $this->send(self::API_TOKEN_URL, false, $config, 'POST');

        $this->setToken($response['access_token']);

        return $this;
    }

    /**
     * Set the access token.
     *
     * @param  string  $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->access_token = $token;

        return $this;
    }

    /**
     * Get the access token.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->access_token;
    }

    /**
     * Get account information.
     *
     * @return array
     */
    public function me()
    {
        return $this->send(self::API_URL . '/me', true, null, 'GET');
    }

    /**
     * Call request with autorization.
     *
     * @param  string  $function
     * @param  array   $params
     * @param  string  $method
     * @return mixed
     */
    public function call($function, array $params = null, $method = 'GET')
    {
        $url = $this->apiUrl($function);

        return $this->send($url, true, $params, $method);
    }

    /**
     * Send a new request.
     *
     * @param  string  $url
     * @param  bool    $auth
     * @param  array   $params
     * @param  string  $method
     * @return mixed
     */
    public function send($url, $auth = false, array $params = null, $method = 'GET')
    {
        $headers   = [];
        $headers[] = 'Accept: application/json';

        if ($auth) {
            $headers[] = 'Authorization: Bearer ' . $this->getToken();
            $params['access_token'] = $this->getToken();
        }

        $querystring = null;
        if (is_array($params)) {
            $querystring = '?' . http_build_query($params);
        }

        $url = $url . ('GET' === $method ? $querystring : null);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        switch ($method) {
            case 'PUT':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
                break;
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, count($params));
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }
        $jsonData = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $response = json_decode($jsonData, true);
        curl_close($ch);

        switch ($httpCode) {
            case '401':
                throw new UnauthorizedException;
                break;
            case '404':
                throw new NotFoundException;
                break;
            case '422':
                throw new UnprocessableEntityException($response);
                break;
            case '500':
                throw new InternalServerErrorException;
                break;
            default:
                return $response;
                break;
        }
    }

    /**
     * Setter overloading method.
     *
     * @param  string  $name
     * @return mixed
     */
    public function __get($name)
    {
        // retrieve resolved
        if (array_key_exists($name, $this->resolved)) {
            return $resolved[$name];
        }

        // push resolved
        if (array_key_exists($name, $this->bundles)) {
            $this->resolved[$name] = new $this->bundles[$name]($this);

            return $this->resolved[$name];
        }

        parent::__get($name);
    }
}
