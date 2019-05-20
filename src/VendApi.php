<?php
namespace Asad\Vend;

use Asad\Vend\Client\VendClient;
use Asad\Vend\Client\VendRequest;
use Asad\Vend\Client\VendResponse;
use Asad\Vend\Authentication;
use Asad\Vend\Models\VendOauthSetting;

class VendApi
{
    private $client = null;
    private $api_url = null;
    private $response = null;
    private $request = null;

    private $authentication = null;

    public function __construct($config_id = null)
    {
        $this->setClient();
        $this->setApiUrl($config_id);
        $this->setAuth(new Authentication($config_id));
    }

    public function setClient(VendClient $client = null): VendApi
    {
        $this->client = $client ?? new VendClient();
        return $this;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setApiUrl($config_id)
    {
        if ($config_id == null) {
            $setting = VendOauthSetting::orderBy('created_at', 'desc')->take(1)->first();
        } else {
            $setting = VendOauthSetting::find($config_id);
        }
        $domain_prefix = null;
        if ($setting) {
            $domain_prefix = $setting->domain_prefix;
        }else{
            throw new VendException("Please check your domain prefix.");
        }
        $this->api_url = 'https://'.$domain_prefix.'.vendhq.com/api/2.0';   
    }

    public function getApiUrl()
    {
        return $this->api_url;
    }

    public function setRequest(VendRequest $request)
    {
        $this->request = $request;
        return $this;
    }

    public function getRequest(): VendRequest
    {
        return $this->request;
    }

    public function setAuth(Authentication $auth)
    {
        $this->authentication = $auth;
        return $this;
    }

    public function getAccessToken()
    {
        return $this->authentication->getAccessToken();
    }

    public function getUrl(): string
    {
        return $this->api_url .'/'. $this->request->getURI();
    }

    public function getRequestVerb()
    {
        return $this->request->getHttpVerb();
    }

    public function getJson()
    {
        return $this->request->getDataJson();
    }

    public function getAction()
    {
        return $this->request->getAction();
    }

    public function get(VendRequest $request): VendResponse
    {
        $this->setRequest($request);
        $access_token = $this->getAccessToken();
        $url = $this->getUrl();
        $http_verb = $this->getRequestVerb();
        $json_data = $this->getJson();
        $action = $this->getAction();

        $this->response = $this->client->execute($action, $http_verb, $url, $access_token, $json_data);
        return $this->response;
    }

}