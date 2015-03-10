<?php
namespace Puppy\Client;

/**
 * Class CgiBuilder
 * @package Puppy\Client
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class CgiBuilder 
{
    /**
     * @var string
     */
    private $command;

    /**
     * @param $cgiPath
     */
    public function __construct($cgiPath)
    {
        $this->setCommand($cgiPath . ' '.__DIR__.'/bootstrap.php');
    }

    /**
     * Getter of $command
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param array $server
     * @return $this
     */
    public function addServer(array $server)
    {
        $this->addToCommand('server', $server);
        return $this;
    }

    /**
     * @param array $get
     * @return $this
     */
    public function addGet(array $get)
    {
        $this->addToCommand('get', $get);
        return $this;
    }

    /**
     * @param array $post
     * @return $this
     */
    public function addPost(array $post)
    {
        $this->addToCommand('post', $post);
        return $this;
    }

    /**
     * @param array $cookies
     * @return $this
     */
    public function addCookies(array $cookies)
    {
        $this->addToCommand('cookies', $cookies);
        return $this;
    }

    /**
     * @param array $env
     * @return $this
     */
    public function addEnv(array $env)
    {
        $this->addToCommand('env', $env);
        return $this;
    }

    /**
     * @param $key
     * @param $arg
     */
    private function addToCommand($key, $arg)
    {
        $this->command .= ' '.$key.'='.base64_encode(serialize($arg));
    }

    /**
     * @param $command
     */
    private function setCommand($command)
    {
        $this->command = $command;
    }
}
