<?php


namespace Tests\Er1z\FakeMock\Generator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\FakeMock as FakeMockAlias;
use Er1z\FakeMock\Generator\RecursiveGenerator;
use Er1z\FakeMock\Metadata\FieldMetadata;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Types\Object_;
use phpDocumentor\Reflection\Types\String_;
use PHPUnit\Framework\TestCase;
use Tests\Er1z\FakeMock\Mocks\Struct\Explicit;
use Tests\Er1z\FakeMock\Mocks\Struct\ExplicitInterface;
use Tests\Er1z\FakeMock\Mocks\Struct\Recursive;

/**
 * @todo: docs: advanced scenarios how to map interface/abstract to class
 * Class RecursiveGeneratorTest
 * @package Tests\Er1z\FakeMock\Generator
 */
class RecursiveGeneratorTest extends TestCase
{

    protected function doTest(RecursiveGenerator $generator, $fqsen)
    {
        $obj = new Recursive();

        $fakemock = new FakeMockAlias();

        $metadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'explicit'),
            new Object_(new Fqsen($fqsen)),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField(), new FakeMock()
        );

        $result = $generator->generateForProperty($metadata, $fakemock);

        $this->assertRegExp('#\d{2}\-\d{3}#si', $result->regex);
        $this->assertEquals('test value', $result->value);
        $this->assertRegExp('#\w+\ \w+#si', $result->fakedName);
    }

    public function testRecursive()
    {
        $this->doTest(new RecursiveGenerator(), '\Tests\Er1z\FakeMock\Mocks\Struct\Explicit');
    }

    public function testRecursiveWithInterface()
    {
        $generator = new RecursiveGenerator();
        $generator->addClassMapping(ExplicitInterface::class, Explicit::class);

        $this->doTest($generator, '\Tests\Er1z\FakeMock\Mocks\Struct\ExplicitInterface');
    }

    public function testRecursiveWithInvalidInterfaceMapping()
    {
        $generator = new RecursiveGenerator();
        $generator->addClassMapping(ExplicitInterface::class, \stdClass::class);

        $this->expectException(\InvalidArgumentException::class);
        $this->doTest($generator, '\Tests\Er1z\FakeMock\Mocks\Struct\ExplicitInterface');
    }

    public function testRecursiveWithUnmappedInterface()
    {
        $generator = new RecursiveGenerator();

        $obj = new Recursive();

        $fakemock = new FakeMockAlias();

        $metadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'explicit'),
            new Object_(new Fqsen('\ArrayAccess')),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField(), new FakeMock()
        );

        $result = $generator->generateForProperty($metadata, $fakemock);
        $this->assertNull($result);
    }

    public function testForNotAnObject()
    {
        $generator = new RecursiveGenerator();

        $obj = new \stdClass();
        $obj->prop = 'test';

        $metadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'prop'),
            new String_(),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField(), new FakeMock()
        );

        $result = $generator->generateForProperty($metadata, $this->createMock(FakeMockAlias::class));
        $this->assertNull($result);
    }

    public function testForNonExistingObject()
    {
        $generator = new RecursiveGenerator();

        $obj = new \stdClass();
        $obj->prop = 'test';

        $metadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'prop'),
            new Object_(new Fqsen('\Szczebrzeszyn')),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField(), new FakeMock()
        );

        $this->expectException(\InvalidArgumentException::class);
        $generator->generateForProperty($metadata, $this->createMock(FakeMockAlias::class));

    }

    public function testForMockedObject()
    {
        $generator = new RecursiveGenerator();

        $propValue = new \ArrayObject();

        $obj = new \stdClass();
        $obj->prop = $propValue;

        $metadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'prop'),
            new String_(),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField(), new FakeMock()
        );

        $result = $generator->generateForProperty($metadata, $this->createMock(FakeMockAlias::class));
        $this->assertNull($result);
    }


}