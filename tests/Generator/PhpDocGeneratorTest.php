<?php

namespace Tests\Er1z\FakeMock\Generator;

use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\FakeMock;
use Er1z\FakeMock\Generator\PhpDocGenerator\GeneratorInterface;
use Er1z\FakeMock\Generator\PhpDocGenerator\Integer;
use Er1z\FakeMock\Metadata\FieldMetadata;
use PHPUnit\Framework\TestCase;

/**
 * @todo
 * Class PhpDocGeneratorTest
 */
class PhpDocGeneratorTest extends TestCase
{
    public function testNoTypeDefined()
    {
        $d = new \Er1z\FakeMock\Generator\AssertGenerator();

        $val = null;
        $obj = new \stdClass();
        $obj->prop = null;
        $prop = new \ReflectionProperty($obj, 'prop');

        $field = new FieldMetadata(
            $obj, $prop, null, $this->createMock(AnnotationCollection::class), new FakeMockField(), new \Er1z\FakeMock\Annotations\FakeMock()
        );

        $result = $d->generateForProperty($field, $this->createMock(FakeMock::class));

        $this->assertNull($result);
    }

    public function testGetGeneratorForNotExisting()
    {
        $d = new \Er1z\FakeMock\Generator\PhpDocGenerator();

        $method = new \ReflectionMethod($d, 'getGenerator');
        $method->setAccessible(true);
        $result = $method->invoke($d, 'asdasdasdasd');
        $this->assertFalse($result);
    }

    public function testGetGeneratorForExisting()
    {
        $d = new \Er1z\FakeMock\Generator\PhpDocGenerator();

        $method = new \ReflectionMethod($d, 'getGenerator');
        $method->setAccessible(true);
        $result = $method->invoke($d, 'Integer');
        $this->assertInstanceOf(Integer::class, $result);
    }

    public function testGenerateForMockAssert()
    {
        $mock = $this->getMockBuilder(GeneratorInterface::class)
            ->getMock();

        $mock->expects($this->once())
            ->method('generateForProperty')
            ->willReturn('123');

        $d = new \Er1z\FakeMock\Generator\PhpDocGenerator();

        $generators = new \ReflectionProperty($d, 'generators');
        $generators->setAccessible(true);
        $generators->setValue($d, [
            'Integer' => $mock,
        ]);

        $obj = new \stdClass();
        $obj->prop = null;

        $prop = new \ReflectionProperty($obj, 'prop');

        $field = new FieldMetadata(
            $obj, $prop, new \phpDocumentor\Reflection\Types\Integer(), new AnnotationCollection(), new FakeMockField(), new \Er1z\FakeMock\Annotations\FakeMock()
        );

        $result = $d->generateForProperty($field, $this->createMock(FakeMock::class));

        $this->assertEquals('123', $result);
    }
}
