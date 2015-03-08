<?php
namespace Puppy\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    public function testCallWithRequestUri()
    {
        $client = new Client(__DIR__ . '/index.php');
        $dom = $client->call('request-uri');
        $this->assertSame('request-uri', $dom->text());
    }

    public function testCallWithDefaultMethod()
    {
        $client = new Client(__DIR__ . '/index.php');
        $dom = $client->call('method');
        $this->assertSame('GET', $dom->text());
    }

    public function testCallWithPostMethod()
    {
        $client = new Client(__DIR__ . '/index.php');
        $dom = $client->call('method', 'POST');
        $this->assertSame('POST', $dom->text());
    }

    public function testCallWithPostValues()
    {
        $client = new Client(__DIR__ . '/index.php');
        $dom = $client->call('post', 'POST', ['key' => 'value']);
        $this->assertSame('value', $dom->text());
    }

    public function testCallWithDefaultType()
    {
        $client = new Client(__DIR__ . '/index.php');
        $dom = $client->call('text-html');
        $this->assertSame('no type', $dom->text());
    }

    public function testCallWithJsonType()
    {
        $client = new Client(__DIR__ . '/index.php');
        $dom = $client->call('application-json', 'POST', [], 'application/json');
        $this->assertSame('application/json', $dom->text());
    }

    public function testClick()
    {
        $client = new Client(__DIR__ . '/index.php');
        $dom = $client->call('click');
        $link = $dom->filter('a')->eq(0);
        $this->assertSame('request-uri', $client->click($link)->text());
    }

    public function testSubmit()
    {
        $client = new Client(__DIR__ . '/index.php');
        $dom = $client->call('submit');
        $form = $dom->filter('form')->eq(0);
        $this->assertSame('value', $client->submit($form, ['key' => 'value'])->text());
    }
}
