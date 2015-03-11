<?php
namespace Puppy\Client;

/**
 * Class ClientTest
 * @package Puppy\Client
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    private $dummyValue = "&|/\\éëèê€ '\"´`^"; //todo eof bugging

    public function testCallWithRequestUri()
    {
        $client = new Client(__DIR__ . '/index.php');
        $response = $client->call(new Request('request-uri'));
        $this->assertSame('request-uri', $response->getContent());
    }

    public function testCallWithDefaultMethod()
    {
        $client = new Client(__DIR__ . '/index.php');
        $response = $client->call(new Request('method'));
        $this->assertSame('GET', $response->getContent());
    }

    public function testCallWithPostMethod()
    {
        $client = new Client(__DIR__ . '/index.php');
        $response = $client->call(new Request('method', 'POST'));
        $this->assertSame('POST', $response->getContent());
    }

    public function testCallWithGetValuesInTheRequestUri()
    {
        $client = new Client(__DIR__ . '/index.php');
        $response = $client->call(new Request('get?key='.$this->getDummyValue(true)));
        $this->assertSame($this->getDummyValue(false), $response->getContent());
    }

    public function testCallWithAdditionalGetValues()
    {
        $client = new Client(__DIR__ . '/index.php');
        $request = new Request('get?key=value');
        $request->setGet(['key' => $this->getDummyValue(false)]);
        $response = $client->call($request);
        $this->assertSame($this->getDummyValue(false), $response->getContent());
    }

    public function testCallWithPostValues()
    {
        $client = new Client(__DIR__ . '/index.php');
        $request = new Request('post', 'POST');
        $request->setPost(['key' => $this->getDummyValue(false)]);
        $response = $client->call($request);
        $this->assertSame($this->getDummyValue(false), $response->getContent());
    }

    public function testCallWithServerValues()
    {
        $client = new Client(__DIR__ . '/index.php');
        $request = new Request('server');
        $request->setServer(['key' => $this->getDummyValue(false)]);
        $response = $client->call($request);
        $this->assertSame($this->getDummyValue(false), $response->getContent());
    }

    public function testCallWithCookieValues()
    {
        $client = new Client(__DIR__ . '/index.php');
        $request = new Request('cookie');
        $request->setCookies(['key' => $this->getDummyValue(false)]);
        $response = $client->call($request);
        $this->assertSame($this->getDummyValue(false), $response->getContent());
    }

    public function testCallWithEnvValues()
    {
        $client = new Client(__DIR__ . '/index.php');
        $request = new Request('env');
        $request->setEnv(['key' => $this->getDummyValue(false)]);
        $response = $client->call($request);
        $this->assertSame($this->getDummyValue(false), $response->getContent());
    }

    public function testCallWithDefaultType()
    {
        $client = new Client(__DIR__ . '/index.php');
        $response = $client->call(new Request('text-html'));
        $this->assertSame('no type', $response->getContent());
    }

    public function testCallWithJsonType()
    {
        $client = new Client(__DIR__ . '/index.php');
        $response = $client->call(new Request('application-json', 'POST', 'application/json'));
        $this->assertSame('application/json', $response->getContent());
    }

    public function testClick()
    {
        $client = new Client(__DIR__ . '/index.php');
        $response = $client->call(new Request('click'));
        $this->assertContains('link', $response->getContent());

        $link = $response->getDom()->selectLink('link')->link();
        $this->assertSame($client->getBaseUri() . '/request-uri', $client->click($link)->getContent());
    }

    public function testSubmit()
    {
        $client = new Client(__DIR__ . '/index.php');
        $response = $client->call(new Request('submit'));
        $form = $response->getDom()->selectButton('submit')->form();
        $this->assertSame('value', $client->submit($form, ['key' => 'value'])->getContent());
    }

    public function testCallWithResponse()
    {
        $client = new Client(__DIR__ . '/index.php');
        $response = $client->call(new Request('response'));
        $this->assertSame('response content', $response->getContent());
    }

    public function testCallWithResponseStatusCode()
    {
        $client = new Client(__DIR__ . '/index.php');
        $response = $client->call(new Request('response'));
        $this->assertSame(201, $response->getStatusCode());
    }

    public function testCallWithResponseHeaders()
    {
        $client = new Client(__DIR__ . '/index.php');
        $response = $client->call(new Request('response'));
        $this->assertSame('201 Created', $response->getHeader('Status'));
        $this->assertSame('12', $response->getHeader('Age'));
    }

    private function getDummyValue($isEncoded)
    {
        if($isEncoded){
            return urlencode($this->dummyValue);
        }
        return $this->dummyValue;
    }
}
