<?php
namespace Asad\Vend\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Asad\Vend\Client\VendClient;
use Asad\Vend\Exception\VendException;
use Asad\Vend\Models\VendOauthSetting;


class VendController extends Controller
{
    
    public function oauth2back(Request $request)
    {
        if($request->input('code')){
            $vend_setting = VendOauthSetting::orderBy('created_at', 'desc')->take(1)->first();
			
			if($vend_setting){
                $code           = $request->input('code');
                $domain_prefix  = $request->input('domain_prefix');
                $redirect_url   = $vend_setting->protocol .'://' . $vend_setting->client_domain .'/vendOauth2back';
                $client_id      = $vend_setting->client_id;
                $client_secret  = $vend_setting->client_secret;

				$request_url 	= 'https://'.$domain_prefix.'.vendhq.com/api/1.0/token';
                
                try {
                    $data = [
                        'form_params' => [
                            'code' => $code,
                            'redirect_uri' => $redirect_url,
                            'client_id' => $client_id,
                            'client_secret' => $client_secret,
                            'grant_type' => 'authorization_code',
                        ]
                    ];
                    $vend_response = $this->getClient()->post($request_url, 'accessCode', $data);
                    $vend_response = $vend_response->getResults();
                } catch (VendException $e) {
                    $vend_response = $e->getResponse();
                    $vend_response->error = $e->getMessage();
                    //dd($vend_response->error);
                    //echo $e->getMessage();
                }
                
                if (isset($vend_response->error)) {
                    return json_encode(['status' => 'failed', 'message' => $vend_response->error]);
                }
                
				if($vend_response != null && isset($vend_response->access_token)){

                    $data['access_token']   = $vend_response->access_token;
                    $data['domain_prefix']  = $vend_response->domain_prefix;
                    $data['token_type']     = $vend_response->token_type;
                    $data['expires_in']     = $vend_response->expires;
                    $data['expires_in_sec'] = $vend_response->expires_in;
                    
                    if (isset($vend_response->refresh_token)) {
                        $data['refresh_token']  = $vend_response->refresh_token;
                    }

					$result = VendOauthSetting::updateOrCreate(
                                                [
                                                    'id' => $vend_setting->id, //This is condition
                                                ],
                                                $data // data array
                                            );

                    $response = ['status' => 'success', 'message' => 'You have successfully generated the access token. Now you can make API request.'];
                    if (!$result) {
                        $response['status'] = 'failed';
                        $response['message'] = 'You have failed to generate the access token. Please check and try again.';
                    }
                    
                    return json_encode($response);
				}
			}
		}

    }

    public function getClient()
    {
        return new VendClient();
    }

    public function Vend()
    {
        return "from Vend api wrapper";
    }

}
