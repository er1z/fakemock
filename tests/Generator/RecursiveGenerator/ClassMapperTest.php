<?php


namespace Tests\Er1z\FakeMock\Generator\RecursiveGenerator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Generator\RecursiveGenerator\ClassMapper;
use Er1z\FakeMock\Metadata\FieldMetadata;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Types\Object_;
use phpDocumentor\Reflection\Types\String_;
use PHPUnit\Framework\TestCase;
use Tests\Er1z\FakeMock\Mocks\Struct\Explicit;
use Tests\Er1z\FakeMock\Mocks\Struct\ExplicitInterface;
use Tests\Er1z\FakeMock\Mocks\Struct\Recursive;

class ClassMapperTest extends TestCase
{

    public function testWithGloballyMappedInterface()
    {
        $obj = new Recursive();

        $metadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'explicit'),
            new Object_(new Fqsen('\Tests\Er1z\FakeMock\Mocks\Struct\ExplicitInterface')),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField(), new FakeMock()
        );

        $generator = new ClassMapper();
        $generator->addClassMapping(ExplicitInterface::class, Explicit::class);

        $result = $generator->getObjectForField($metadata);

        $this->assertInstanceOf(Explicit::class, $result);
    }

    public function testWithLocalAnnotationMappedInterface()
    {
        $obj = new Recursive();

        $metadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'explicit'),
            new Object_(new Fqsen('\Tests\Er1z\FakeMock\Mocks\Struct\ExplicitInterface')),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField([
                'mapToClass'=>Explicit::class
            ]), new FakeMock()
        );

        $generator = new ClassMapper();

        $result = $generator->getObjectForField($metadata);

        $this->assertInstanceOf(Explicit::class, $result);
    }

    public function testWithGlobalAnnotationMappedInterface()
    {
        $obj = new Recursive();

        $metadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'explicit'),
            new Object_(new Fqsen('\Tests\Er1z\FakeMock\Mocks\Struct\ExplicitInterface')),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField(), new FakeMock([
                'classMappings'=>[
                    ExplicitInterface::class=>Explicit::class
                ]
            ])
        );

        $generator = new ClassMapper();

        $result = $generator->getObjectForField($metadata);

        $this->assertInstanceOf(Explicit::class, $result);
    }

    public function testWithExplicitClass()
    {
        $obj = new Recursive();

        $metadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'explicit'),
            new Object_(new Fqsen('\Tests\Er1z\FakeMock\Mocks\Struct\Explicit')),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField(), new FakeMock()
        );

        $generator = new ClassMapper();

        $result = $generator->getObjectForField($metadata);

        $this->assertInstanceOf(Explicit::class, $result);
    }

    public function testWithExplicitObject()
    {
        $obj = new Recursive();

        $obj->explicit = new Explicit();

        $metadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'explicit'),
            new Object_(new Fqsen('\Tests\Er1z\FakeMock\Mocks\Struct\Explicit')),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField(), new FakeMock()
        );

        $generator = new ClassMapper();

        $result = $generator->getObjectForField($metadata);

        $this->assertEquals($obj->explicit, $result);
    }

    public function testWithNonMapped()
    {
        $obj = new Recursive();

        $metadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'explicit'),
            new Object_(new Fqsen('\Tests\Er1z\FakeMock\Mocks\Struct\ExplicitInterface')),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField(), new FakeMock()
        );

        $generator = new ClassMapper();

        $result = $generator->getObjectForField($metadata);

        $this->assertNull($result);
    }

    public function testWithNonObject()
    {
        $obj = new Recursive();

        $metadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'explicit'),
            new String_(),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField(), new FakeMock()
        );

        $generator = new ClassMapper();

        $result = $generator->getObjectForField($metadata);

        $this->assertNull($result);
    }

    public function testNonExistingClass()
    {
        $obj = new Recursive();

        $metadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'explicit'),
            new Object_(new Fqsen('\Szczebrzeszyn')),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField(), new FakeMock()
        );

        $generator = new ClassMapper();
        $generator->addClassMapping(ExplicitInterface::class, Explicit::class);

        $this->expectException(\InvalidArgumentException::class);
        $generator->getObjectForField($metadata);
    }

    public function testEmptyFqsen()
    {
        $obj = new Recursive();

        $metadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'explicit'),
            new Object_(),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField(), new FakeMock()
        );

        $generator = new ClassMapper();
        $result = $generator->getObjectForField($metadata);

        $this->assertNull($result);
    }

    public function testNonExistingMappingTarget()
    {
        $obj = new Recursive();

        $metadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'explicit'),
            new Object_(new Fqsen('\stdClass')),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField(), new FakeMock()
        );

        $generator = new ClassMapper();
        $generator->addClassMapping('stdClass', 'Szczebrzeszyn');

        $this->expectException(\InvalidArgumentException::class);
        $generator->getObjectForField($metadata);
    }

    public function testMappingTargetNotRelatedToType()
    {
        $obj = new Recursive();

        $metadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'explicit'),
            new Object_(new Fqsen('\Tests\Er1z\FakeMock\Mocks\Struct\ExplicitInterface')),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField(), new FakeMock()
        );

        $generator = new ClassMapper();
        $generator->addClassMapping(ExplicitInterface::class, \stdClass::class);

        $this->expectException(\InvalidArgumentException::class);
        $generator->getObjectForField($metadata);
    }


}