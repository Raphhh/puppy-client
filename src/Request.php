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
    private $get = array();

    /**
     * @var array
     */
    private $post = array();

    /**
     * @var array
     */
    private $cookies = array();

    /**
     * @var array
     */
    private $server = array();

    /**
     * @var array
     */
    private $env = array();

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
        $get = $this->get;
        parse_str(parse_url($this->getRequestUri(), PHP_URL_QUERY), $get);
        return $get;
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
        $server['REQUEST_URI'] = $this->getRequestUri();
        $server['REQUEST_METHOD'] = $this->getMethod();
        $server['HTTP_ACCEPT'] = $this->getAcceptedType();

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
}
