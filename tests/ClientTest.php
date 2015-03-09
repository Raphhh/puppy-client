<?php
namespace Puppy\Client;

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
        $link = $response->getDom()->filter('a')->eq(0);
        $this->assertSame('request-uri', $client->click($link)->getContent());
    }

    public function testSubmit()
    {
        $client = new Client(__DIR__ . '/index.php');
        $response = $client->call('submit');
        $form = $response->getDom()->filter('form')->eq(0);
        $this->assertSame('value', $client->submit($form, ['key' => 'value'])->getContent());
    }
}
