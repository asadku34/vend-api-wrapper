<?php
namespace Asad\Vend\Api;

use Asad\Vend\Abstracts\RestApi;

class SupplierApi extends RestApi
{
    public function __construct($config_id=null)
    {
        parent::__construct($config_id);
    }
    /**
     * @param $module = 'Supplier'
     *
     */
    public function allSuppliers($criteria = [])
    {
        $request = $this->createRequest('all-records', 'suppliers', $criteria);
        return $this->makeRequest($request);
    }

    public function getSupplierById($supplier_id)
    {
        $request = $this->createRequest('single-record', 'suppliers', [$supplier_id]);
        return $this->makeRequest($request);
    }


}