<?php
namespace Asad\Vend\Api;

use Asad\Vend\Abstracts\RestApi;

class UserApi extends RestApi
{
    public function __construct($config_id=null)
    {
        parent::__construct($config_id);
    }
    /**
     * @param $module = 'User'
     * 
     */
    public function allUsers($criteria = [])
    {
        $request = $this->createRequest('all-records', 'users', $criteria);
        return $this->makeRequest($request);
    }

    public function getUserById($user_id)
    {
        $request = $this->createRequest('single-record', 'users', [$user_id]);
        return $this->makeRequest($request);
    }


}