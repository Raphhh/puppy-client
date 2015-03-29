<?php
namespace Puppy\Client\CGI;

/**
 * Class CommandBuilder
 * @package Puppy\Client
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class CommandBuilder
{
    /**
     * @var string
     */
    private $commandParts = [
        'post' => '',
        'globals' => [],
        'cgi' => '',
    ];

    /**
     * @param $cgiPath
     */
    public function __construct($cgiPath)
    {
        $this->setCgiPath($cgiPath);
    }

    /**
     * Getter of $command
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->flat(array_filter($this->commandParts));
    }

    /**
     * @param array $server
     * @return $this
     */
    public function addServer(array $server)
    {
        $this->addToGlobals($server);
        return $this;
    }

    /**
     * @param string$requestUri
     * @param array $get
     * @return $this
     */
    public function addGet($requestUri, array $get)
    {
        $query = $this->buildQuery($get);
        $this->addToGlobals([
            'REQUEST_URI' => rtrim($requestUri . '?' . $query, '?'),
            'QUERY_STRING' => $query,
        ]);
        return $this;
    }

    /**
     * @param $method
     * @param string $contentType
     * @param array $post
     * @return $this
     */
    public function addPost($method, $contentType, array $post)
    {
        if($method === 'POST' && $post) {
            $data = $this->buildQuery($post);
            $this->commandParts['post'] = 'echo ' . $data . ' |';
            $this->addToGlobals([
                'REQUEST_METHOD' => $method,
                'CONTENT_TYPE' => $contentType,
                'CONTENT_LENGTH' => strlen($data),
            ]);
        }
        return $this;
    }

    /**
     * @param array $cookies
     * @return $this
     */
    public function addCookies(array $cookies)
    {
        if($cookies) {
            $this->addToGlobals(['HTTP_COOKIE' => $this->buildQuery($cookies)]);
        }
        return $this;
    }

    /**
     * @param array $env
     * @return $this
     */
    public function addEnv(array $env)
    {
        $this->addToGlobals($env);
        return $this;
    }

    /**
     * @param string $cgiPath
     */
    private function setCgiPath($cgiPath)
    {
        $this->commandParts['cgi'] = $cgiPath;
    }

    /**
     * @param array $globals
     */
    private function addToGlobals(array $globals)
    {
        foreach(array_filter($globals) as $key => $value){
            $this->commandParts['globals'][$key] = $key . '=' . $value;
        }
    }

    /**
     * @param array $data
     * @return string
     */
    private function buildQuery(array $data)
    {
        $result = '';
        foreach($data as $key => $value){
            $result .= "&$key=$value";
        }
        return urlencode(ltrim($result, '&'));
    }

    /**
     * @param array $data
     * @return string
     */
    private function flat(array $data){
        foreach($data as $key => $value){
            if(is_array($value)){
                $data[$key] = $this->flat($value);
            }
        }
        return implode(' ', $data);
    }
}
