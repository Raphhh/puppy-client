<?php
namespace Puppy\Client;

use Puppy\Client\CGI\CommandBuilder;
use Puppy\Client\Cgi\CommandDirector;
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
     * @param Request $request
     * @return Response
     */
    public function call(Request $request)
    {
        $server = $request->getServer();
        $server['SCRIPT_FILENAME'] = $this->getEntryPath();
        $request->setServer($server);

        $director = new CommandDirector(new CommandBuilder($this->getCgiPath()));
        $executor = new Executor();
        $result = $executor->read($director->getCommand($request));

        return new Response($this->getBaseUri(), $result);
    }

    /**
     * @param Link $link
     * @return Response
     */
    public function click(Link $link)
    {
        return $this->call(new Request($link->getUri()));
    }

    /**
     * @param Form $form
     * @param array $values
     * @return Response
     */
    public function submit(Form $form, array $values = array())
    {
        $form->setValues($values);
        $request = new Request($form->getUri(), $form->getMethod());
        $request->setPost($form->getPhpValues());
        return $this->call($request);
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
    private function setEntryPath($entryPath)
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
