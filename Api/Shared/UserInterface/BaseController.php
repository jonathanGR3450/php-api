<?php

namespace Api\Shared\UserInterface;

class BaseController
{
    /**
    * __call magic method.
    */
    public function __call($name, $arguments)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }
    /**
    * Get URI elements.
    *
    * @return array
    */
    protected function getUriSegments()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode('/', $uri);
        return $uri;
    }
    /**
    * Get querystring params.
    *
    * @return mixed
    */
    protected function queryGet(string $key, mixed $default = null): mixed
    {
        return $_GET[$key] ?? $default;
    }

    /**
    * Get querystring params.
    *
    * @return mixed
    */
    protected function queryPost(string $key, mixed $default = null): mixed
    {
        $json = file_get_contents('php://input');

        // Convertir el JSON en un objeto o matriz de PHP
        $data = json_decode($json, true);
        return $data[$key] ?? $default;
    }

    /**
    * Get querystring params.
    *
    * @return mixed
    */
    protected function queryAllPost(): array
    {
        $json = file_get_contents('php://input');

        // Convertir el JSON en un objeto o matriz de PHP
        $data = json_decode($json, true);
        return $data;
    }

    /**
    * Send API output.
    *
    * @param mixed $data
    * @param string $httpHeader
    */
    protected function sendOutput($data, $httpHeaders=array())
    {
        header_remove('Set-Cookie');
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
        echo $data;
        exit;
    }
}
