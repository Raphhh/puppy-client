<?php
namespace Puppy\Client;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\DomCrawler\Link;

/**
 * Class Client
 * @package Puppy\Client
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class Client
{
    /**
     * @var string
     */
    private $entryPath;

    /**
     * @var string
     */
    private $baseUri;

    /**
     * @var array
     */
    private $cookies = [];

    /**
     * @param string $entryPath
     * @param string $baseUri
     */
    public function __construct($entryPath, $baseUri = 'http://website.dev')
    {
        $this->setEntryPath($entryPath);
        $this->setBaseUri($baseUri);
    }

    /**
     * @param $requestUri
     * @param string $method
     * @param array $post
     * @param string $accept
     * @return Response
     */
    public function call($requestUri, $method='GET', array $post = array(), $accept = '')
    {
        $serverDump = $_SERVER;
        $getDump = $_GET;
        $postDump = $_POST;
        $cookieDump = $_COOKIE;

        $_SERVER['REQUEST_URI'] = $requestUri;
        $_SERVER['REQUEST_METHOD'] = strtoupper($method);
        $_SERVER['HTTP_ACCEPT'] = $accept;
        parse_str(parse_url($requestUri, PHP_URL_QUERY), $_GET);
        $_POST = $post;
        $_COOKIE = $this->getCookies();

        ob_start();
        require $this->getEntryPath();

        $_SERVER = $serverDump;
        $_GET = $getDump;
        $_POST = $postDump;
        $_COOKIE = $cookieDump;

        return new Response($this, ob_get_clean());
    }

    /**
     * @param Link $link
     * @return Response
     */
    public function click(Link $link)
    {
        return $this->call($link->getUri());
    }

    /**
     * @param Form $form
     * @param array $values
     * @return Response
     */
    public function submit(Form $form, array $values = array())
    {
        $form->setValues($values);
        return $this->call($form->getUri(), $form->getMethod(), $form->getPhpValues());
    }

    /**
     * Getter of $entryPath
     *
     * @return string
     */
    public function getEntryPath()
    {
        return $this->entryPath;
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
     * Getter of $cookies
     *
     * @return array
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * Setter of $cookies
     *
     * @param array $cookies
     */
    public function setCookies(array $cookies)
    {
        $this->cookies = $cookies;
    }

    /**
     * Setter of $entryPath
     *
     * @param string $entryPath
     */
    private function setEntryPath($entryPath)
    {
        $this->entryPath = (string)$entryPath;
    }

    /**
     * Setter of $baseUri
     *
     * @param string $baseUri
     */
    private function setBaseUri($baseUri)
    {
        $this->baseUri = (string)$baseUri;
    }
}
