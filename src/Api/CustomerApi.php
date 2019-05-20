<?php
namespace Asad\Vend\Api;

use Asad\Vend\Abstracts\RestApi;
use Asad\Vend\Client\VendRequest;

class CustomerApi extends RestApi
{
    public function __construct($config_id=null)
    {
        parent::__construct($config_id);
    }
    /**
     * @param $module = 'Customer'
     * 
     */
    public function allCustomers()
    {
        $request = $this->createRequest('all-records', 'customers', []);
        return $this->makeRequest($request);
    }

    public function getCustomerById($customer_id)
    {
        $request = $this->createRequest('single-record', 'customers', [$customer_id]);
        return $this->makeRequest($request);
    }


}