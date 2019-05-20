<?php
namespace Asad\Vend\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use GuzzleHttp\TransferStats;

use Asad\Vend\Client\VendResponse;
use Asad\Vend\Exception\VendException;

class VendClient
{
    private $client;
    public function __construct()
    {
        $this->setClient(new Client());
    }

     /* 
     * @param Guzzle Client
     * 
     * @return Vend Client
     *  */

    public function setClient($client)
    {
        $this->client = $client;

        return $this->client;
    }

    public function execute($action, $http_verb, $url, $access_token, array $data = null)
    {

        if ($data !== null) {
            $data_header['json'] = $data;
        }
        $data_header['headers'] = [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$access_token
        ];
        
        try {
            $res = $this->client->request($http_verb, $url, $data_header);
        } catch (GuzzleRequestException $e) {
            if ($e->hasResponse()) {
                $res = $e->getResponse();
            }else{
                throw new VendException($e->getMessage());
            }
        }
        
        return new VendResponse($res, $action);
    }

    public function get(string $url, string $access_token)
    {
        $action = 'get';
        try {
            $res = $this->client->request('GET', $url);
        } catch (GuzzleRequestException $e) {
            if ($e->hasResponse()) {
                $res = $e->getResponse();
            }else{
                throw new VendException($e->getMessage());
            }
        }
        
        return new VendResponse($res, $action);
    }

    public function post($url, $action='post', $form_param=[])
    {
        try {
            $res = $this->client->request('POST', $url, $form_param);
        } catch (GuzzleRequestException $e) {
            if ($e->hasResponse()) {
                $res = $e->getResponse();
            }else{
                throw new VendException($e->getMessage());
            }
        }
        
        return new VendResponse($res, $action);
    }

}