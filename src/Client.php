<?php
namespace Puppy\Client;

use Symfony\Component\DomCrawler\Form;
use Symfony\Component\DomCrawler\Link;
use TRex\Cli\Executor;

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
     * @var string
     */
    private $cgiPath;

    /**
     * @var array
     */
    private $cookies = [];

    /**
     * @param string $entryPath
     * @param string $baseUri
     * @param string $cgiPath
     */
    public function __construct($entryPath, $baseUri = 'http://website.dev', $cgiPath = 'php-cgi')
    {
        $this->setEntryPath($entryPath);
        $this->setBaseUri($baseUri);
        $this->setCgiPath($cgiPath);
    }

    /**
     * @param $requestUri
     * @param string $method
     * @param array $post
     * @param string $accept
     * @return Response
     */
    public function call($requestUri, $method='GET', array $post = array(), $accept = '')//todo travailler avec un objet Request
    {
        $server = [];
        $server['REQUEST_URI'] = $requestUri;
        $server['SCRIPT_FILENAME'] = $this->getEntryPath();
        $server['REQUEST_METHOD'] = strtoupper($method);
        $server['HTTP_ACCEPT'] = $accept;

        $get = [];
        parse_str(parse_url($requestUri, PHP_URL_QUERY), $get);

        $cgiBuilder = new CgiBuilder($this->getCgiPath());
        $cgiBuilder->addServer($server);
        $cgiBuilder->addGet($get);
        $cgiBuilder->addPost($post);
        $cgiBuilder->addCookies($this->getCookies());
        $command = $cgiBuilder->getCommand();

        $executor = new Executor();
        $result = $executor->read($command);

        return new Response($this, $result);
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
     * Getter of $entryPath
     *
     * @return string
     */
    public function getEntryPath()
    {
        return $this->entryPath;
    }

    /**
     * Setter of $entryPath
     *
     * @param string $entryPath
     */
    public function setEntryPath($entryPath)
    {
        $this->entryPath = (string)$entryPath;
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
    public function setBaseUri($baseUri)
    {
        $this->baseUri = (string)$baseUri;
    }

    /**
     * Getter of $cgiPath
     *
     * @return string
     */
    public function getCgiPath()
    {
        return $this->cgiPath;
    }

    /**
     * Setter of $cgiPath
     *
     * @param string $cgiPath
     */
    public function setCgiPath($cgiPath)
    {
        $this->cgiPath = (string)$cgiPath;
    }
}
