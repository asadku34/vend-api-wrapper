<?php
namespace Asad\Vend\Api;

use Asad\Vend\Abstracts\RestApi;

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
    public function allCustomers($criteria = [])
    {
        $request = $this->createRequest('all-records', 'customers', $criteria);
        return $this->makeRequest($request);
    }

    public function getCustomerById($customer_id)
    {
        $request = $this->createRequest('single-record', 'customers', [$customer_id]);
        return $this->makeRequest($request);
    }


}