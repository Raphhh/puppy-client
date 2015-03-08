<?php
namespace Puppy\Client;

use Symfony\Component\DomCrawler\Crawler;

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

    public function __construct($entryPath)
    {
        $this->setEntryPath($entryPath);
    }

    /**
     * @param $requestUri
     * @param string $method
     * @param array $post
     * @param string $accept
     * @return Crawler
     */
    public function call($requestUri, $method='GET', array $post = array(), $accept = '')
    {
        $serverDump = $_SERVER;
        $postDump = $_POST;

        $_SERVER['REQUEST_URI'] = $requestUri;
        $_SERVER['REQUEST_METHOD'] = strtoupper($method);
        $_SERVER['HTTP_ACCEPT'] = $accept;
        $_POST = $post;

        ob_start();
        require $this->getEntryPath();

        $_SERVER = $serverDump;
        $_POST = $postDump;

        return new Crawler(ob_get_clean());
    }

    /**
     * @param Crawler $link
     * @return Crawler
     */
    public function click(Crawler $link)
    {
        return $this->call($link->attr('href'));
    }

    /**
     * @param Crawler $form
     * @param array $values
     * @return Crawler
     */
    public function submit(Crawler $form, array $values = array())
    {
        return $this->call($form->attr('action'), $form->attr('method'), $values);
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
}
