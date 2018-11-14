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
use PHPUnit\Framework\TestCase;
use Tests\Er1z\FakeMock\Mocks\Struct\Recursive;

/**
 * Class RecursiveGeneratorTest
 * @package Tests\Er1z\FakeMock\Generator
 */
class RecursiveGeneratorTest extends TestCase
{

    public function testForDisabled()
    {
        $generator = new RecursiveGenerator();

        $obj = new Recursive();

        $fakemock = new FakeMockAlias();

        $metadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'explicit'),
            new Object_(),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField([
                'recursive'=>false
            ]), new FakeMock()
        );

        $result = $generator->generateForProperty($metadata, $fakemock);
        $this->assertNull($result);
    }

    public function testForNoMappingFound()
    {
        $generator = new RecursiveGenerator();

        $obj = new Recursive();

        $fakemock = new FakeMockAlias();

        $metadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'explicit'),
            new Object_(new Fqsen('\Tests\Er1z\FakeMock\Mocks\Struct\ExplicitInterface')),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField([
                'recursive'=>true
            ]), new FakeMock()
        );

        $result = $generator->generateForProperty($metadata, $fakemock);
        $this->assertNull($result);
    }

    public function testForMappedObject()
    {
        $generator = new RecursiveGenerator();

        $obj = new Recursive();

        $fakemock = new FakeMockAlias();

        $metadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'explicit'),
            new Object_(new Fqsen('\Tests\Er1z\FakeMock\Mocks\Struct\Explicit')),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField([
                'recursive'=>true
            ]), new FakeMock()
        );

        $result = $generator->generateForProperty($metadata, $fakemock);
        $this->assertRegExp('#\d{2}\-\d{3}#si', $result->regex);
        $this->assertEquals('test value', $result->value);
        $this->assertRegExp('#\w+\ \w+#si', $result->fakedName);

    }

    public function testAddClassMapping()
    {
        $classMapperMock = $this->createMock(RecursiveGenerator\ClassMapper::class);

        $classMapperMock->expects($this->once())->method('addClassMapping')->with('interface', 'target');

        $generator = new RecursiveGenerator($classMapperMock);
        $generator->addClassMapping('interface', 'target');
    }


}