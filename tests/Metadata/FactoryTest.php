<?php


namespace Tests\Er1z\FakeMock\Metadata;


use Doctrine\Common\Annotations\Reader;
use Er1z\FakeMock\Annotations\FakeMock;
use Er1z\FakeMock\Metadata\Factory;
use PHPUnit\Framework\TestCase;

/**
 * @todo
 * Class FactoryTest
 * @package Tests\Er1z\FakeMock\Metadata
 */
class FactoryTest extends TestCase
{

    /**
     * @var \Prophecy\Prophet
     */
    protected $prophet;

    protected function setup()
    {
        $this->prophet = new \Prophecy\Prophet;
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }

    public function testGetObjectConfiguration()
    {
        $reader = $this->createMock(Reader::class);

        $reader->expects($this->once())
            ->method('getClassAnnotation')
            ->willReturn(
                new FakeMock([
                    'useAsserts'=>false
                ])
            );

        $factory = new Factory($reader);
        $result = $factory->getObjectConfiguration(new \ReflectionClass(\stdClass::class));

        $this->assertInstanceOf(FakeMock::class, $result);
        $this->assertFalse($result->useAsserts);
    }

}