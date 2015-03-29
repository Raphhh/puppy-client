<?php
namespace Puppy\Client;

/**
 * Class Request
 * @package Puppy\Client
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class Request 
{
    /**
     * @var string
     */
    private $requestUri;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $acceptedType;

    /**
     * @var array
     */
    private $get = [];

    /**
     * @var array
     */
    private $post = [];

    /**
     * @var array
     */
    private $cookies = [];

    /**
     * @var array
     */
    private $server = [
        'SERVER_PROTOCOL' => 'HTTP/1.1',
        'REDIRECT_STATUS' => '200',
        'REQUEST_METHOD' => 'GET',
        'GATEWAY_INTERFACE' => 'CGI/1.1',
    ];

    /**
     * @var array
     */
    private $env = [];

    /**
     * @param string $requestUri
     * @param string $method
     * @param string $acceptedType
     */
    public function __construct($requestUri, $method='GET', $acceptedType = '')
    {
        $this->setRequestUri($requestUri);
        $this->setMethod($method);
        $this->setAcceptedType($acceptedType);
    }

    /**
     * Getter of $requestUri
     *
     * @return string
     */
    public function getRequestUri()
    {
        return $this->requestUri;
    }

    /**
     * Setter of $requestUri
     *
     * @param string $requestUri
     */
    public function setRequestUri($requestUri)
    {
        $this->requestUri = (string)$requestUri;
    }

    /**
     * Getter of $method
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Setter of $method
     *
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = strtoupper($method);
    }

    /**
     * Getter of $acceptedType
     *
     * @return string
     */
    public function getAcceptedType()
    {
        return $this->acceptedType;
    }

    /**
     * Setter of $acceptedType
     *
     * @param string $acceptedType
     */
    public function setAcceptedType($acceptedType)
    {
        $this->acceptedType = (string)$acceptedType;
    }

    /**
     * Getter of $get
     *
     * @return array
     */
    public function getGet()
    {
        $get = [];
        parse_str(parse_url($this->getRequestUri(), PHP_URL_QUERY), $get);
        return array_merge($get, $this->get);
    }

    /**
     * Setter of $get
     *
     * @param array $get
     */
    public function setGet(array $get)
    {
        $this->get = $get;
    }

    /**
     * Getter of $post
     *
     * @return array
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Setter of $post
     *
     * @param array $post
     */
    public function setPost(array $post)
    {
        $this->post = $post;
    }

    /**
     * Getter of $cookies
     *
     * @return array
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * Setter of $cookies
     *
     * @param array $cookies
     */
    public function setCookies(array $cookies)
    {
        $this->cookies = $cookies;
    }

    /**
     * Getter of $server
     *
     * @return array
     */
    public function getServer()
    {
        $server = $this->server;
        $server = $this->setOptionalKey($server, 'REQUEST_METHOD', $this->getMethod());
        $server = $this->setOptionalKey($server, 'HTTP_ACCEPT', $this->getAcceptedType());

        return $server;
    }

    /**
     * Setter of $server
     *
     * @param array $server
     */
    public function setServer(array $server)
    {
        $this->server = $server;
    }

    /**
     * Getter of $env
     *
     * @return array
     */
    public function getEnv()
    {
        return $this->env;
    }

    /**
     * Setter of $env
     *
     * @param array $env
     */
    public function setEnv(array $env)
    {
        $this->env = $env;
    }

    /**
     * @param array $vars
     * @param $key
     * @param $value
     * @return mixed
     */
    private function setOptionalKey(array $vars, $key, $value)
    {
        if ($value) {
            $vars[$key] = $value;
        }
        return $vars;
    }
}
