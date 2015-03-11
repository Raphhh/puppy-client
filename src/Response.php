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
     * @var string
     */
    private $baseUri;

    /**
     * @var string
     */
    private $response;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var array
     */
    private $cookies = [];

    /**
     * @var string
     */
    private $content;

    /**
     * @param string $baseUri
     * @param string $response
     */
    public function __construct($baseUri, $response)
    {
        $this->setBaseUri($baseUri);
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
        $crawler = new Crawler(null, $this->getbaseUri());
        $crawler->addContent($this->getContent(), $this->getHeader('Content-type'));
        return $crawler;
    }

    /**
     * Getter of $cookies
     *
     * @return array
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * Getter of $baseUri
     *
     * @return string
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * Setter of $baseUri
     *
     * @param string $baseUri
     */
    private function setBaseUri($baseUri)
    {
        $this->baseUri = $baseUri;
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
     * http://stackoverflow.com/questions/3241326/set-more-than-one-http-header-with-the-same-name
     *
     * @param $endOfHeaders
     */
    private function initHeaders($endOfHeaders)
    {
        $headers = [];
        foreach ($this->explodeHeaderBlock($endOfHeaders) as $line) {

            $headerData = $this->explodeHeaderLine($line);
            $key = trim($headerData[0]);
            $value = trim($headerData[1]);

            if($key === 'Set-Cookie'){
                $this->addCookie($this->parseCookieValue($value));
            }

            if(isset($headers[$key])){
                $headers[$key] .= ', ' . $value;
            }else {
                $headers[$key] = $value;
            }
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

    /**
     * @param string $value
     * @return array
     */
    private function parseCookieValue($value)
    {
        $cookieData = explode('=', explode(';', $value)[0]);
        return [$cookieData[0] => $cookieData[1]];
    }

    /**
     * @param array $cookie
     */
    private function addCookie(array $cookie)
    {
        $this->cookies = array_merge($this->cookies, $cookie);
    }
}
