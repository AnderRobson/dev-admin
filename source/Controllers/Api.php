<?php

namespace Source\Controllers;

use Source\Library\webservice\Webservice;

class Api
{
    /**
     * @var Webservice
     */
    private $webservice;

    public function __construct($request = null)
    {
        $this->webservice = new Webservice();
    }

    public function get($data): void
    {
        $function = $data['function'];
        unset($data['function']);

        if (method_exists($this->webservice, $function)) {
            $this->webservice->$function($data);
        }
    }

    public function post($data): void
    {
        $function = 'post' . ucfirst($data['function']);
        unset($data['function']);

        if (method_exists($this->webservice, $function)) {
            $this->webservice->$function($this->convertToArray($data));
        }
    }

    public function convertToArray($data)
    {
        $response = null;

        if (is_array($data)) {
            $response = count($data) == 1 ? reset($data) : $data;
        }

        if (is_string($data)) {
            $response = json_decode($data, true);
            if (! $response) {
                $response = $data;
            }
        }

        return $response;
    }
}
