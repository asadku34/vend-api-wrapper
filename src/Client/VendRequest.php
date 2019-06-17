<?php

namespace Asad\Vend\Client;

use Asad\Vend\Exception\RequestException;
class VendRequest
{
    /**
     * Query parameter 
     * */ 
    protected $parameter = null;
    protected $action = null;
    protected $module = null;
    protected $http_verb = null;
    protected $URI = null;
    protected $data_json = null;

    /**
	* VendRequest constructor.
	*
	* @param Query
	*/
    public function __construct($action, $module, array $param) 
    {
        $this->setModule($module);
        $this->processRequest($action, $param);
    }

    public function setAction(string $action): VendRequest
    {
        $this->action = $action;
        return $this;
    }

    public function getAction(): String
    {
        return $this->action;
    }

    public function setModule(string $module): VendRequest
    {
        if(is_null($module)) {
            throw new RequestException("Module Name Missing");
        }
        $this->module = $module;
        return $this;
    }

    public function getModule()
    {
        return $this->module;
    }

    public function setHttpVerb(string $http_verb): VendRequest
    {
        $this->http_verb = $http_verb;
        return $this;
    }

    public function getHttpVerb()
    {
        return $this->http_verb;
    }

    public function processRequest($action, $param): array
    {
        $this->parameter = [];
        if ($action === 'all-records') {
            foreach ($param as $key => $val) {
                $this->parameter[$key] = $val;
            }
            $this->setAction('All Records');
            $this->setHttpVerb('GET');
            $this->URI = $this->module.(($this->getQuery()) ? "?".$this->getQuery() : '');
        }

        if ($action === 'single-record') {
            $this->setAction('Single Record');
            $this->setHttpVerb('GET');
            $this->URI = $this->module .'/'. implode('',$param);
        }
        
        return $this->parameter;
    }

    public function getQuery(): string
    {
        $param = [];
        foreach ($this->parameter as $key => $value) {
            $param[$key] = (string)$value;
        }
        return (count($param) > 0) ? urldecode(http_build_query($param)) : '';
    }

    public function getURI()
    {
        return $this->URI;
    }

    public function setDataJson($data_json): VendRequest
    {
        $this->data_json = $data_json;
        return $this;
    }

    public function getDataJson() 
    {
        return $this->data_json;
    }


}