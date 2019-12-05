<?php
namespace Asad\Vend\Api;

use Asad\Vend\Abstracts\RestApi;

class CustomerGroupApi extends RestApi
{
    public function __construct($config_id=null)
    {
        parent::__construct($config_id);
    }
    /**
     * @param $module = 'Customer'
     * 
     */
    public function allCustomerGroups($criteria = [])
    {
        $request = $this->createRequest('all-records', 'customer_groups', $criteria);
        return $this->makeRequest($request);
    }

}