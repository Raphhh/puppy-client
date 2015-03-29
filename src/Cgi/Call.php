<?php
namespace Puppy\Client\CGI;

use Puppy\Client\Client;
use Puppy\Client\Request;
use Puppy\Client\Response;
use TRex\Cli\Executor;

/**
 * Class Call
 * @package Puppy\Client\CGI
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class Call
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var Executor
     */
    private $executor;

    /**
     * @param Client $client
     * @param Executor $executor
     */
    public function __construct(Client $client, Executor $executor)
    {
        $this->setClient($client);
        $this->setExecutor($executor);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function execute(Request $request)
    {
        $command = $this->buildCommand($request);
        return new Response(
            $this->getClient()->getBaseUri(),
            $this->getExecutor()->read($command)
        );
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
     * Getter of $executor
     *
     * @return Executor
     */
    public function getExecutor()
    {
        return $this->executor;
    }

    /**
     * Setter of $executor
     *
     * @param Executor $executor
     */
    private function setExecutor(Executor $executor)
    {
        $this->executor = $executor;
    }

    /**
     * @param Request $request
     * @return string
     */
    private function buildCommand(Request $request)
    {
        $director = new CommandDirector(new CommandBuilder($this->getClient()->getCgiPath()));
        return $director->getCommand($request);
    }
}
