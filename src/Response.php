<?php
namespace Puppy\Client;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Class Response
 * @package Puppy\Client
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class Response 
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $response;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var string
     */
    private $content;

    /**
     * @param Client $client
     * @param string $response
     */
    public function __construct(Client $client, $response)
    {
        $this->setClient($client);
        $this->setResponse($response);
        $this->init();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getResponse();
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return (int)$this->getHeader('Status');
    }

    /**
     * Getter of $headers
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }


    /**
     * Getter of $headers
     *
     * @param string $key
     * @return array
     */
    public function getHeader($key)
    {
        if (isset($this->headers[$key])) {
            return $this->headers[$key];
        }
        return '';
    }

    /**
     * Getter of $content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return Crawler
     */
    public function getDom()
    {
        $crawler = new Crawler(null, $this->getClient()->getBaseUri());
        $crawler->addContent($this->getContent(), 'text/html'); //todo
        return $crawler;
    }

    /**
     * Getter of $client
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Setter of $client
     *
     * @param Client $client
     */
    private function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Setter of $headers
     *
     * @param array $headers
     */
    private function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * Setter of $content
     *
     * @param string $content
     */
    private function setContent($content)
    {
        $this->content = (string)$content;
    }

    /**
     * Getter of $response
     *
     * @return string
     */
    private function getResponse()
    {
        return $this->response;
    }

    /**
     * Setter of $response
     *
     * @param string $response
     */
    private function setResponse($response)
    {
        $this->response = (string)$response;
    }

    /**
     *
     */
    private function init()
    {
        $endOfHeaders = strpos($this->getResponse(), "\n\n");
        $this->initHeaders($endOfHeaders);
        $this->initContent($endOfHeaders);
    }

    /**
     * @param $endOfHeaders
     */
    private function initContent($endOfHeaders)
    {
        $this->setContent(trim(substr($this->getResponse(), $endOfHeaders)));
    }

    /**
     * @param $endOfHeaders
     */
    private function initHeaders($endOfHeaders)
    {
        $headers = [];
        foreach ($this->explodeHeaderBlock($endOfHeaders) as $line) {
            $headerData = $this->explodeHeaderLine($line);
            $headers[trim($headerData[0])] = trim($headerData[1]);
        }
        $this->setHeaders($headers);
    }

    /**
     * @param $endOfHeaders
     * @return array
     */
    private function explodeHeaderBlock($endOfHeaders)
    {
        return array_filter(explode("\n", substr($this->getResponse(), 0, $endOfHeaders)));
    }

    /**
     * @param $line
     * @return array
     */
    private function explodeHeaderLine($line)
    {
        return array_pad(explode(': ', $line), 2, '');
    }
}
