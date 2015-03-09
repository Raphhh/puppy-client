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
    private $content;

    /**
     * @param string $content
     */
    public function __construct($content)
    {
        $this->setContent($content);
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
        return new Crawler($this->getContent());
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
}
