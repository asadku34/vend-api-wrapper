<?php
namespace Asad\Vend\Api;

use Asad\Vend\Abstracts\RestApi;
use Asad\Vend\Client\VendRequest;

class ProductApi extends RestApi
{
    public function __construct($config_id=null)
    {
        parent::__construct($config_id);
    }
    /**
     * @param $module = 'Product'
     * 
     */
    public function allProducts()
    {
        $request = $this->createRequest('all-records', 'products', []);
        return $this->makeRequest($request);
    }

    public function getProductById($product_id)
    {
        $request = $this->createRequest('single-record', 'products', [$product_id]);
        return $this->makeRequest($request);
    }


}