<?php
namespace Puppy\Client\PhpUnit;

use Puppy\Client\Client;

/**
 * Class TestCase
 * @package Puppy\Client
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @return Client
     */
    public function createClient()
    {
        if(empty($GLOBALS['ENTRY_PATH'])){
            throw new \InvalidArgumentException('Client param ENTRY_PATH not set.');
        }

        $client = new Client($GLOBALS['ENTRY_PATH']);

        if(!empty($GLOBALS['BASE_URI'])){
            $client->setBaseUri($GLOBALS['BASE_URI']);
        }

        if(!empty($GLOBALS['CGI_PATH'])){
            $client->setBaseUri($GLOBALS['CGI_PATH']);
        }

        return $client;
    }
}
