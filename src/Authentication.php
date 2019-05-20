<?php
namespace Asad\Vend;

use Illuminate\Database\Eloquent\Model;
use Asad\Vend\Client\VendClient;
use Asad\Vend\Exception\VendException;
use Asad\Vend\Models\VendOauthSetting;

class Authentication
{
    /**
     * Vend Authentication API url base part
     */
    private $auth_api = 'api/1.0/token'; 
    
    /**
     * Api access token
     */
    protected $access_token = null;
    /**
     * Configuration: Multiple authentication can be operated by define the configuration id.
     */
    private $config_id = null;

    public function __construct($config_id = null)
    {
        $this->setAccessToken($config_id);
    }

    /**
     * @param string $config_id
     */
    public function setAccessToken($config_id)
    {
        try {
            $this->validAccessToken($config_id);
        } catch (VendException $e) {
            echo $e->getMessage();
            exit;
        }
        
    }

    public function getAccessToken(): string 
    {
        return $this->access_token;
    }

    public function validAccessToken($config_id)
    {
        if ($config_id == null) {
            $setting = VendOauthSetting::orderBy('created_at', 'desc')->take(1)->first();
        } else {
            $setting = VendOauthSetting::find($config_id);
        }

        if (is_null($setting)) {
            throw new VendException("Vend API package configuration is not found. Make sure you have executed the artisan command.");
        }

        $now = time() + 300; // Generate Refresh Token before five minutes.
        if($setting->expires_in <= $now){
            try {
                $this->refreshAccessToken($setting);
            } catch (VendException $e) {
                echo $e->getMessage(); 
                echo "<br>It's seems something happened to your refresh token.";
                exit;
            }
        }else{
            $this->access_token = $setting->access_token;
        }

        return $this->access_token;
    }

    public function refreshAccessToken($setting)
    {
        $id = $setting->id;

        $domain_prefix = $setting->domain_prefix;
        
        $refresh_url	= $this->getRefreshTokenUrl($domain_prefix);
        
        $data = [
            'form_params' => [
                'refresh_token' => $setting->refresh_token,
                'client_id'     => $setting->client_id,
                'client_secret' => $setting->client_secret,
                'grant_type'    => 'refresh_token',
            ]
        ];

        $response = $this->getClient()->post($refresh_url, 'refreshToken', $data)->getResults();
        if (isset($response->error)) {
            throw new VendException($response->error);
        }

        $setting = VendOauthSetting::find($id);
        $setting->access_token  = $response->access_token;
        $setting->expires_in    = $response->expires;
        $setting->expires_in_sec= $response->expires_in;
        $setting->save();
        
        $this->access_token = $response->access_token;
		
    }

    public function getRefreshTokenUrl($domain_prefix)
    {
        return 'https://'.$domain_prefix.'.vendhq.com/'.$this->auth_api;
    }

    public function getClient()
    {
        return new VendClient();
    }

}