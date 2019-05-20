<?php

namespace Asad\Vend\Exception;

use Asad\Vend\Exception\VendException;

class ResponseException extends VendException
{

    protected $http_status_code = null;

    public function __construct($message, $http_status = null, $exception_json = null) {
        $this->http_status_code = $http_status;
        parent::__construct($message, $exception_json);
    }

}