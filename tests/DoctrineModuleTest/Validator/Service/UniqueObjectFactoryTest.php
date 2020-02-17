<?php

namespace DoctrineModule\Validator\Service;

use PHPUnit\Framework\TestCase;
use DoctrineModule\Validator\UniqueObject;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Interop\Container\ContainerInterface;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-09-04 at 11:57:37.
 *
 * @coversDefaultClass DoctrineModule\Validator\Service\UniqueObjectFactory
 * @group validator
 */
class UniqueObjectFactoryTest extends TestCase
{
    /**
     * @var UniqueObjectFactory
     */
    private $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() : void
    {
        $this->object = new UniqueObjectFactory;
    }

    /**
     * @covers ::__invoke
     */
    public function test__invoke()
    {
        $options = [
            'target_class' => 'Foo\Bar',
            'fields'       => ['test'],
        ];

        $repository = $this->prophesize(ObjectRepository::class);
        $objectManager = $this->prophesize(ObjectManager::class);
        $objectManager->getRepository('Foo\Bar')
            ->shouldBeCalled()
            ->willReturn($repository->reveal());

        $container = $this->prophesize(ContainerInterface::class);
        $container->get('doctrine.entitymanager.orm_default')
            ->shouldBeCalled()
            ->willReturn($objectManager->reveal());

        $instance = $this->object->__invoke(
            $container->reveal(),
            UniqueObject::class,
            $options
        );
        $this->assertInstanceOf(UniqueObject::class, $instance);
    }
}
