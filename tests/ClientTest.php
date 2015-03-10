<?php
namespace Puppy\Client;

/**
 * Class ClientTest
 * @package Puppy\Client
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testCallWithRequestUri()
    {
        $client = new Client(__DIR__ . '/index.php');
        $response = $client->call('request-uri');
        $this->assertSame('request-uri', $response->getContent());
    }

    public function testCallWithDefaultMethod()
    {
        $client = new Client(__DIR__ . '/index.php');
        $response = $client->call('method');
        $this->assertSame('GET', $response->getContent());
    }

    public function testCallWithPostMethod()
    {
        $client = new Client(__DIR__ . '/index.php');
        $response = $client->call('method', 'POST');
        $this->assertSame('POST', $response->getContent());
    }

    public function testCallWithPostValues()
    {
        $client = new Client(__DIR__ . '/index.php');
        $response = $client->call('post', 'POST', ['key' => 'value']);
        $this->assertSame('value', $response->getContent());
    }

    public function testCallWithGetValues()
    {
        $client = new Client(__DIR__ . '/index.php');
        $response = $client->call('post?key=value');
        $this->assertSame('value', $response->getContent());
    }

    public function testCallWithDefaultType()
    {
        $client = new Client(__DIR__ . '/index.php');
        $response = $client->call('text-html');
        $this->assertSame('no type', $response->getContent());
    }

    public function testCallWithJsonType()
    {
        $client = new Client(__DIR__ . '/index.php');
        $response = $client->call('application-json', 'POST', [], 'application/json');
        $this->assertSame('application/json', $response->getContent());
    }

    public function testClick()
    {
        $client = new Client(__DIR__ . '/index.php');
        $response = $client->call('click');
        $this->assertContains('link', $response->getContent());

        $link = $response->getDom()->selectLink('link')->link();
        $this->assertSame($client->getBaseUri() . '/request-uri', $client->click($link)->getContent());
    }

    public function testSubmit()
    {
        $client = new Client(__DIR__ . '/index.php');
        $response = $client->call('submit');
        $form = $response->getDom()->selectButton('submit')->form();
        $this->assertSame('value', $client->submit($form, ['key' => 'value'])->getContent());
    }

    public function testCallWithResponse()
    {
        $client = new Client(__DIR__ . '/index.php');
        $response = $client->call('response');
        $this->assertSame('response content', $response->getContent());
    }

    public function testCallWithResponseStatusCode()
    {
        $client = new Client(__DIR__ . '/index.php');
        $response = $client->call('response');
        $this->assertSame(201, $response->getStatusCode());
    }

    public function testCallWithResponseHeaders()
    {
        $client = new Client(__DIR__ . '/index.php');
        $response = $client->call('response');
        $this->assertSame('201 Created', $response->getHeader('Status'));
        $this->assertSame('12', $response->getHeader('Age'));
    }
}
