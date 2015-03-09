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
    private $content;

    /**
     * @param Client $client
     * @param string $content
     */
    public function __construct(Client $client, $content)
    {
        $this->setClient($client);
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
     * Setter of $content
     *
     * @param string $content
     */
    private function setContent($content)
    {
        $this->content = (string)$content;
    }
}
