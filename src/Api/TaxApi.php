<?php
namespace Asad\Vend\Api;

use Asad\Vend\Abstracts\RestApi;

class TaxApi extends RestApi
{
    public function __construct($config_id=null)
    {
        parent::__construct($config_id);
    }
    /**
     * @param $module = 'Tax'
     *
     */
    public function allTaxes($criteria = [])
    {
        $request = $this->createRequest('all-records', 'taxes', $criteria);
        return $this->makeRequest($request);
    }

}