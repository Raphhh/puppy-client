<?php
namespace Puppy\Client\Cgi;

use Puppy\Client\Request;

/**
 * Class CommandDirector
 * @package Puppy\Client
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class CommandDirector
{
    /**
     * @var CommandBuilder
     */
    private $builder;

    /**
     * @param CommandBuilder $builder
     */
    public function __construct(CommandBuilder $builder)
    {
        $this->setBuilder($builder);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function getCommand(Request $request)
    {
        $this->getBuilder()
            ->addServer($request->getServer())
            ->addEnv($request->getEnv())
            ->addGet($request->getRequestUri(), $request->getGet())
            ->addPost($request->getMethod(), 'application/x-www-form-urlencoded', $request->getPost()) //todo
            ->addCookies($request->getCookies());

        return $this->getBuilder()->getCommand();
    }

    /**
     * Getter of $builder
     *
     * @return CommandBuilder
     */
    private function getBuilder()
    {
        return $this->builder;
    }

    /**
     * Setter of $builder
     *
     * @param CommandBuilder $builder
     */
    private function setBuilder(CommandBuilder $builder)
    {
        $this->builder = $builder;
    }
}
