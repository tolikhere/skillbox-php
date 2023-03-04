<?php

namespace App;

use CurlHandle;

class CurlService
{
    // class variable that will hold the curl request handler
    private $handler;

    // class variable that will hold the url
    private string $url;

    // class variable that will hold the info of our request
    private array $info;

    // class variable that will hold the data inputs of our request
    private $data;

    // class variable that will tell us what type of request method to use (defaults to get)
    private string $method;

    // class variable that will hold the response of the request in string
    private $content;

    // class variable that will hold the content type of the request in string (defaults to 'text/html; charset=UTF-8')
    private string $contentType;

    public function __construct(
        string $url = '',
        string $contentType = 'text/html; charset=UTF-8',
        string $method = 'get'
    ) {
        $this->setUrl($url);
        $this->setContentType($contentType);
        $this->setMethod($method);
    }

    // function to set data inputs to send
    public function setUrl(string $url): CurlService
    {
        $this->url = $url;
        return $this;
    }

    // function to set data inputs to send
    public function setData(string|array $data): CurlService
    {
        $this->data = $data;
        return $this;
    }

    // function to set request method (defaults to get)
    public function setMethod(string $method): CurlService
    {
        $this->method = $method;
        return $this;
    }

    // function that will send our request
    public function send(): CurlService
    {
        try {
            $this->handler = curl_init();

            switch (strtolower($this->method)) {
                case 'post':
                    curl_setopt_array($this->handler, [
                        CURLOPT_URL => $this->url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => $this->data,
                        CURLOPT_HTTPHEADER => ["Content-Type: {$this->contentType}"],
                    ]);
                    break;
                default:
                    curl_setopt_array($this->handler, [
                        CURLOPT_URL => $this->url,
                        CURLOPT_RETURNTRANSFER => true,
                    ]);
                    break;
            }

            $this->content = curl_exec($this->handler);

            $this->info = curl_getinfo($this->handler);
        } catch (\Exception $e) {
            file_put_contents('error_log.log', $e->getMessage(), FILE_APPEND);
            die('<center><h1>Internal Server Error</h1></center>');
        }

        return $this;
    }

    // setting request content type
    public function setContentType(string $type): CurlService
    {
        $this->contentType = $type;
        return $this;
    }

    // returning content of a response
    public function getContent(): mixed
    {
        return $this->content;
    }

    // Get information regarding a specific transfer
    public function getInfo(): array
    {
        return $this->info;
    }

    // return the last response code
    public function getStatusCode(): int
    {
        return $this->info['http_code'];
    }

    // function that will close the connection of the curl handler
    public function close()
    {
        curl_close($this->handler);
        unset($this->handler);
    }
}
