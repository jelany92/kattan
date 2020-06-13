<?php
/**
 * Created by PhpStorm.
 * User: uwe.janssen
 * Date: 04.07.2018
 * Time: 13:31
 */

namespace common\exceptions;


class AuthObjectInvalidException extends AdminModuleException
{
    /**
     * Constructor.
     * @param string $message error message
     * @param int $code error code
     * @param \Exception $previous The previous exception used for the exception chaining.
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct( $message, $code, $previous);
    }

}