<?php

/*
 * This file is part of Parasut.
 *
 * (c) Sercan Çakır <srcnckr@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Parasut\Exception;

use Exception;
use RuntimeException;

/**
 * HttpException
 *
 * @package   Parasut
 * @author    Sercan Çakır <srcnckr@gmail.com>
 * @license   MIT License
 * @copyright 2015
 */
class HttpException extends RuntimeException
{
    /**
     * Constructor.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  \Exception  $previous
     * @return void
     */
    public function __construct($message = null, $code = 400, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * String representation of the exception.
     *
     * @return string
     */
    public function __toString()
    {
        http_response_code($this->getCode());

        return parent::__toString();
    }
}
