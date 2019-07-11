<?php
namespace Asad\Vend\Api;

use Asad\Vend\Abstracts\RestApi;

class BrandApi extends RestApi
{
    public function __construct($config_id=null)
    {
        parent::__construct($config_id);
    }
    /**
     * @param $module = 'Brand'
     * 
     */
    public function allBrands($criteria = [])
    {
        $request = $this->createRequest('all-records', 'brands', $criteria);
        return $this->makeRequest($request);
    }

    public function getBrandById($tag_id)
    {
        $request = $this->createRequest('single-record', 'brands', [$tag_id]);
        return $this->makeRequest($request);
    }


}