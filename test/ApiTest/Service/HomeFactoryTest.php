<?php

namespace ApiTest\Service;

use Api\Service\Home;
use Api\Service\HomeFactory;
use Interop\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;
use Zend\Expressive\Router\RouterInterface;

class HomeFactoryTest extends TestCase
{
    /** @var ContainerInterface */
    protected $container;

    protected function setUp()
    {
        $this->container = $this->prophesize(ContainerInterface::class);
        $router = $this->prophesize(RouterInterface::class);

        $this->container->get(RouterInterface::class)->willReturn($router);
    }

    public function testFactoryWithoutTemplate()
    {
        $factory = new HomeFactory();

        $this->assertInstanceOf(HomeFactory::class, $factory);

        $homePage = $factory($this->container->reveal());

        $this->assertInstanceOf(Home::class, $homePage);
    }
}
