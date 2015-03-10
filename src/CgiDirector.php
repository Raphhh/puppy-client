<?php
namespace Puppy\Client;

/**
 * Class CgiDirector
 * @package Puppy\Client
 * @author Raphaël Lefebvre <raphael@raphaellefebvre.be>
 */
class CgiDirector 
{
    /**
     * @var CgiBuilder
     */
    private $builder;

    /**
     * @param CgiBuilder $builder
     */
    public function __construct(CgiBuilder $builder)
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
            ->addGet($request->getGet())
            ->addPost($request->getPost())
            ->addCookies($request->getCookies())
            ->addEnv($request->getEnv());

        return $this->getBuilder()->getCommand();
    }

    /**
     * Getter of $builder
     *
     * @return CgiBuilder
     */
    private function getBuilder()
    {
        return $this->builder;
    }

    /**
     * Setter of $builder
     *
     * @param CgiBuilder $builder
     */
    private function setBuilder(CgiBuilder $builder)
    {
        $this->builder = $builder;
    }
}
