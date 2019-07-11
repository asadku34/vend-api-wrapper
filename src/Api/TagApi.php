<?php
namespace Asad\Vend\Api;

use Asad\Vend\Abstracts\RestApi;

class TagApi extends RestApi
{
    public function __construct($config_id=null)
    {
        parent::__construct($config_id);
    }
    /**
     * @param $module = 'Tag'
     * 
     */
    public function allTags($criteria = [])
    {
        $request = $this->createRequest('all-records', 'tags', $criteria);
        return $this->makeRequest($request);
    }

    public function getTagById($tag_id)
    {
        $request = $this->createRequest('single-record', 'tags', [$tag_id]);
        return $this->makeRequest($request);
    }


}