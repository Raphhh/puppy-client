<?php
namespace Puppy\Client;

/**
 * Class ClientTest
 * @package Puppy\Client
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{

    public function testRun()
    {
        $client = new Client('test');
        $this->setExpectedException('Puppy\Route\RouteException', 'No route found for uri "/"');
        $client->run('/');
    }
}
