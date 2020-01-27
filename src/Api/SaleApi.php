<?php
namespace Asad\Vend\Api;

use Asad\Vend\Abstracts\RestApi;

class SaleApi extends RestApi
{
    public function __construct($config_id=null)
    {
        parent::__construct($config_id);
    }
    /**
     * @param $module = 'Sale'
     *
     */
    public function allSales($criteria = [])
    {
        $request = $this->createRequest('all-records', 'sales', $criteria);
        return $this->makeRequest($request);
    }

    public function getSaleById($sale_id)
    {
        $request = $this->createRequest('single-record', 'sales', [$sale_id]);
        return $this->makeRequest($request);
    }


}