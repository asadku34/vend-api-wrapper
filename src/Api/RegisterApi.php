<?php
namespace Asad\Vend\Api;

use Asad\Vend\Abstracts\RestApi;

class RegisterApi extends RestApi
{
    public function __construct($config_id=null)
    {
        parent::__construct($config_id);
    }
    /**
     * @param $module = 'Register'
     *
     */
    public function allRegisters($criteria = [])
    {
        $request = $this->createRequest('all-records', 'registers', $criteria);
        return $this->makeRequest($request);
    }

    public function getRegisterById($register_id)
    {
        $request = $this->createRequest('single-record', 'registers', [$register_id]);
        return $this->makeRequest($request);
    }


}