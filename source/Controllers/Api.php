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

        public function get($data = null)
        {
            $function = $data['function'];
            unset($data['function']);

            if (method_exists($this->webservice, $function)) {
                $this->webservice->$function($data);
            }

            return;
        }

        public function post($data = null)
        {
            $function = $data['function'];
            unset($data['function']);

            if (method_exists($this->webservice, $function)) {
                $this->webservice->$function($this->convertToArray($data));
            }

            return;
        }

        public function convertToArray($data)
        {
            if (is_array($data) && count($data) == 1) {
                $data = reset($data);
            }

            $response = null;

            if (is_string($data)) {
                $response = json_decode($data, true);
                if (! $response) {
                    $response = $data;
                }
            }

            return $response;
        }
    }