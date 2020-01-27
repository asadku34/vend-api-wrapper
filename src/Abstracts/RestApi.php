<?php
namespace Asad\Vend\Abstracts;

use Asad\Vend\VendApi;
use Asad\Vend\Client\VendRequest;

abstract class RestApi
{
    protected $vend_api = null;
    public function __construct($cofig_id)
    {
        $this->setVendApi(new VendApi($cofig_id));
    }

    /**
     * @param VendApi $vend_api
     *
     * @return VendApi
     */
    public function setVendApi(VendApi $vend_api): RestApi
    {
        $this->vend_api = $vend_api;
        return $this;
    }

    /**
     * @return VendApi
     */
    public function getVendApi():VendApi
    {
        return $this->vend_api;
    }

    /**
     * @param string $action = 'get'
     *
     * @param string $module = 'customer'
     *
     * @param array $param = [customer_id]
     *
     * @return VendRequest object
     */
    public function createRequest($action, $module, array $param): VendRequest
    {
        return new VendRequest($action, $module, $param);
    }

    /**
     * @param VendRequest $request
     *
     * @return VendApi response
     */
    public function makeRequest(VendRequest $request)
    {
        return $this->getVendApi()->get($request);
    }

}