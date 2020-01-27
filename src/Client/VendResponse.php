<?php

namespace Asad\Vend\Client;

use Asad\Vend\Exception\ResponseException;
use GuzzleHttp\Psr7\Response;

class VendResponse
{
  	protected $response = null;
    protected $results = null;
    protected $status = null;
    protected $error_message = null;
    protected $array_response = null;
	protected $http_status_code = null;


    /**sss
	* VendResponse constructor.
	*
	* @param Response $response
	*/
    public function __construct(Response $response, $action)
    {
		$this->setResponse($response);
		$this->checkHttpStatusCode();
		$this->parseResponse($action);
    }
    /**
	 * @param Response $response
	 *
	 * @return VendResponse
	 */
	public function setResponse(Response $response): VendResponse
	{
		$this->response = $response;
		return $this;
	}

	/**
	 * @return VendResponse
	 *
	 * @throws ResponseException
	 */
	protected function parseResponse($action): VendResponse
	{
		$json_response = $this->response->getBody()->getContents();
		$invoke_function = camel_case(str_replace(' ', '', $action));
		return $this->$invoke_function($json_response);

	}

	private function setSuccessResponse($json_response)
	{
		$this->setResults($json_response);
		$array_response = $this->toArray($json_response);
		$this->setStatus('success');
		return $this;
	}

	private function yieldException($json_response)
	{
		if ($this->http_status_code == 500) {
			$this->internalServerException($json_response);
		}

		if ($this->http_status_code == 404) {
			$this->noContentException($json_response);
		}

		$error_response = json_decode($json_response);
		$this->setStatus('error');
		throw new ResponseException($error_response->error_description, $this->http_status_code, json_encode($error_response));
	}

	private function internalServerException($json_response)
	{
		$error_response = json_decode($json_response);
		$this->setStatus('error');
		throw new ResponseException($error_response->error_description, $this->http_status_code, json_encode($error_response));
	}

	private function noContentException($json_response)
	{
		$this->setStatus("error");
		$error_response = [
			'code' 		=> 'NO_CONTENT',
			'details' 	=> [],
			'message' 	=> 'There is no content available for the request.',
			'status' 	=> 'success',
		];
		throw new ResponseException("There is no content available for the request.", $this->http_status_code, json_encode($error_response));
	}

	/**
	 * Parse response
	 */
	private function refreshToken($json_response)
	{
		return $this->setSuccessResponse($json_response);
	}

	private function get($json_response)
	{
		return $this->recordResponse($json_response);
	}

	private function post($json_response)
	{
		return $this->recordResponse($json_response);
	}

	private function accessCode($json_response)
	{
		return $this->recordResponse($json_response);
	}

	//Record Response
	private function recordResponse($json_response)
	{
		if ($this->http_status_code == 200) {
			return $this->setSuccessResponse($json_response);
		}
		$this->yieldException($json_response);
	}

	private function allRecords($json_response)
	{
		return $this->recordResponse($json_response);
	}

	private function singleRecord($json_response)
	{
		return $this->recordResponse($json_response);
	}


	/**
	 * Check HTTP status code (silent/No exceptions!)
	 * @return int
	 */
	protected function checkHttpStatusCode(): int
	{
		$this->http_status_code = $this->response->getStatusCode();
		return $this->http_status_code;
	}
	/**
	 * @param string $json_response
	 *
	 * @return array
	 */
	public function toArray(string $json_response): array
	{
		$this->array_response = json_decode($json_response, true);
		return $this->array_response;
	}

	/**
	 * @return array
	 */
	public function getResults()
	{
		return $this->results;
	}
	/**
	 * @param array $results
	 *
	 * @return $this
	 */
	public function setResults($results)
	{
		$this->results = json_decode($results);
		return $this;
	}
	/**
	 * @return string
	 */
	public function getStatus(): string
	{
		return $this->status;
	}
	/**
	 * @param string $status
	 *
	 * @return VendRespone
	 */
	public function setStatus(string $status): VendResponse
	{
		$this->status = $status;
		return $this;
	}
	/**
	 * @return array
	 */
	public function getArrayResponse(): array
	{
		return $this->array_response;
	}
	/**
	 * @param array $array_response
	 *
	 * @return VendResponse
	 */
	public function setArrayResponse(array $array_response): VendResponse
	{
		$this->array_response = $array_response;
		return $this;
	}
	/**
	 * @return mixed
	 */
	public function getErrorMessage()
	{
		return $this->error_message;
	}
	/**
	 * @param $error_message
	 *
	 * @return VendResponse
	 */
	public function setErrorMessage($error_message): VendResponse
	{
		$this->error_message = $error_message;
		return $this;
	}
	/**
	 * @return int
	 */
	public function getHttpStatusCode(): int
	{
		return intval($this->http_status_code);
	}


}