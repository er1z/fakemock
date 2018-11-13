<?php

namespace Tests\Er1z\FakeMock\Generator;

use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\FakeMock as FakeMockAlias;
use Er1z\FakeMock\Metadata\FieldMetadata;
use Er1z\FakeMock\Generator\AssertGenerator\GeneratorInterface;
use phpDocumentor\Reflection\Types\String_;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\Ip;
use Tests\Er1z\FakeMock\AssertsTestTrait;

class AssertGeneratorTest extends TestCase
{
    use AssertsTestTrait;

    public function testGenerateDisabledAssertConditions()
    {
        $d = new \Er1z\FakeMock\Generator\AssertGenerator();

        $val = null;
        $obj = new \stdClass();
        $obj->prop = null;
        $prop = new \ReflectionProperty($obj, 'prop');

        $field = new FieldMetadata(
            $obj, $prop, new String_(), $this->createMock(AnnotationCollection::class), new FakeMockField([
                'useAsserts' => false,
            ]), new FakeMock()
        );

        $result = $d->generateForProperty($field, $this->createMock(FakeMockAlias::class));

        $this->assertNull($result);
    }

    public function testGetGeneratorForNotExisting()
    {
        $d = new \Er1z\FakeMock\Generator\AssertGenerator();

        $method = new \ReflectionMethod($d, 'getGenerator');
        $method->setAccessible(true);
        $result = $method->invoke($d, 'asdasdasdasd');
        $this->assertFalse($result);
    }

    public function testGetGeneratorForExisting()
    {
        $d = new \Er1z\FakeMock\Generator\AssertGenerator();

        $method = new \ReflectionMethod($d, 'getGenerator');
        $method->setAccessible(true);
        $result = $method->invoke($d, 'Ip');
        $this->assertInstanceOf(\Er1z\FakeMock\Generator\AssertGenerator\Ip::class, $result);
    }

    public function testGenerateForNoAsserts()
    {
        $d = new \Er1z\FakeMock\Generator\AssertGenerator();

        $obj = new \stdClass();
        $obj->prop = null;

        $prop = new \ReflectionProperty($obj, 'prop');

        $field = new FieldMetadata(
            $obj, $prop, new String_(), $this->createMock(AnnotationCollection::class), new FakeMockField(), new FakeMock()
        );

        $result = $d->generateForProperty($field, $this->createMock(FakeMockAlias::class));

        $this->assertNull($result);
    }

    public function testGenerateForMockAssert()
    {
        $mock = $this->getMockBuilder(GeneratorInterface::class)
            ->getMock();

        $mock->expects($this->once())
            ->method('generateForProperty')
            ->willReturn('123');

        $d = new \Er1z\FakeMock\Generator\AssertGenerator();

        $generators = new \ReflectionProperty($d, 'generators');
        $generators->setAccessible(true);
        $generators->setValue($d, [
            'Ip' => $mock,
        ]);

        $obj = new \stdClass();
        $obj->prop = null;

        $prop = new \ReflectionProperty($obj, 'prop');

        $field = new FieldMetadata(
            $obj, $prop, new String_(), new AnnotationCollection([
                new Ip(),
        ]), new FakeMockField([
            'useAsserts' => true,
            ]),
            new FakeMock()
        );

        $result = $d->generateForProperty($field, $this->createMock(FakeMockAlias::class));

        $this->assertEquals('123', $result);
    }
}
