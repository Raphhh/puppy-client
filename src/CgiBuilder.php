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
     */
    public function addServer(array $server)
    {
        $this->addToCommand('server', $server);
    }

    /**
     * @param array $get
     */
    public function addGet(array $get)
    {
        $this->addToCommand('get', $get);
    }

    /**
     * @param array $post
     */
    public function addPost(array $post)
    {
        $this->addToCommand('post', $post);
    }

    /**
     * @param array $cookies
     */
    public function addCookies(array $cookies)
    {
        $this->addToCommand('cookies', $cookies);
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
