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

        $metadata = new FieldMetadata();
        $metadata->object = $obj;
        $metadata->property = new \ReflectionProperty($obj, 'explicit');
        $metadata->type = new Object_(new Fqsen('\Tests\Er1z\FakeMock\Mocks\Struct\ExplicitInterface'));
        $metadata->annotations = $this->createMock(AnnotationCollection::class);
        $metadata->configuration = new FakeMockField();
        $metadata->objectConfiguration = new FakeMock();

        $generator = new ClassMapper();
        $generator->addClassMapping(ExplicitInterface::class, Explicit::class);

        $result = $generator->getObjectForField($metadata);

        $this->assertInstanceOf(Explicit::class, $result);
    }

    public function testWithLocalAnnotationMappedInterface()
    {
        $obj = new Recursive();

        $metadata = new FieldMetadata();
        $metadata->object = $obj;
        $metadata->property = new \ReflectionProperty($obj, 'explicit');
        $metadata->type = new Object_(new Fqsen('\Tests\Er1z\FakeMock\Mocks\Struct\ExplicitInterface'));
        $metadata->annotations = $this->createMock(AnnotationCollection::class);
        $metadata->configuration = new FakeMockField([
            'mapToClass'=>Explicit::class
        ]);
        $metadata->objectConfiguration = new FakeMock();

        $generator = new ClassMapper();

        $result = $generator->getObjectForField($metadata);

        $this->assertInstanceOf(Explicit::class, $result);
    }

    public function testWithGlobalAnnotationMappedInterface()
    {
        $obj = new Recursive();

        $metadata = new FieldMetadata();
        $metadata->object = $obj;
        $metadata->property = new \ReflectionProperty($obj, 'explicit');
        $metadata->type = new Object_(new Fqsen('\Tests\Er1z\FakeMock\Mocks\Struct\ExplicitInterface'));
        $metadata->annotations = $this->createMock(AnnotationCollection::class);
        $metadata->configuration = new FakeMockField();
        $metadata->objectConfiguration = new FakeMock([
            'classMappings'=>[
                ExplicitInterface::class=>Explicit::class
            ]
        ]);

        $generator = new ClassMapper();

        $result = $generator->getObjectForField($metadata);

        $this->assertInstanceOf(Explicit::class, $result);
    }

    public function testWithExplicitClass()
    {
        $obj = new Recursive();

        $metadata = new FieldMetadata();
        $metadata->object = $obj;
        $metadata->property = new \ReflectionProperty($obj, 'explicit');
        $metadata->type = new Object_(new Fqsen('\Tests\Er1z\FakeMock\Mocks\Struct\Explicit'));
        $metadata->annotations = $this->createMock(AnnotationCollection::class);
        $metadata->configuration = new FakeMockField();
        $metadata->objectConfiguration = new FakeMock();

        $generator = new ClassMapper();

        $result = $generator->getObjectForField($metadata);

        $this->assertInstanceOf(Explicit::class, $result);
    }

    public function testWithExplicitObject()
    {
        $obj = new Recursive();

        $obj->explicit = new Explicit();

        $metadata = new FieldMetadata();
        $metadata->object = $obj;
        $metadata->property = new \ReflectionProperty($obj, 'explicit');
        $metadata->type = new Object_(new Fqsen('\Tests\Er1z\FakeMock\Mocks\Struct\Explicit'));
        $metadata->annotations = $this->createMock(AnnotationCollection::class);
        $metadata->configuration = new FakeMockField();
        $metadata->objectConfiguration =  new FakeMock();

        $generator = new ClassMapper();

        $result = $generator->getObjectForField($metadata);

        $this->assertEquals($obj->explicit, $result);
    }

    public function testWithNonMapped()
    {
        $obj = new Recursive();

        $metadata = new FieldMetadata();
        $metadata->object = $obj;
        $metadata->property = new \ReflectionProperty($obj, 'explicit');
        $metadata->type = new Object_(new Fqsen('\Tests\Er1z\FakeMock\Mocks\Struct\ExplicitInterface'));
        $metadata->annotations = $this->createMock(AnnotationCollection::class);
        $metadata->configuration = new FakeMockField();
        $metadata->objectConfiguration = new FakeMock();

        $generator = new ClassMapper();

        $result = $generator->getObjectForField($metadata);

        $this->assertNull($result);
    }

    public function testWithNonObject()
    {
        $obj = new Recursive();

        $metadata = new FieldMetadata();
        $metadata->object = $obj;
        $metadata->property = new \ReflectionProperty($obj, 'explicit');
        $metadata->type = new String_();
        $metadata->annotations = $this->createMock(AnnotationCollection::class);
        $metadata->configuration = new FakeMockField();
        $metadata->objectConfiguration = new FakeMock();

        $generator = new ClassMapper();

        $result = $generator->getObjectForField($metadata);

        $this->assertNull($result);
    }

    public function testNonExistingClass()
    {
        $obj = new Recursive();

        $metadata = new FieldMetadata();
        $metadata->object = $obj;
        $metadata->property = new \ReflectionProperty($obj, 'explicit');
        $metadata->type = new Object_(new Fqsen('\Szczebrzeszyn'));
        $metadata->annotations = $this->createMock(AnnotationCollection::class);
        $metadata->configuration = new FakeMockField();
        $metadata->objectConfiguration = new FakeMock();

        $generator = new ClassMapper();
        $generator->addClassMapping(ExplicitInterface::class, Explicit::class);

        $this->expectException(\InvalidArgumentException::class);
        $generator->getObjectForField($metadata);
    }

    public function testEmptyFqsen()
    {
        $obj = new Recursive();

        $metadata = new FieldMetadata();
        $metadata->object = $obj;
        $metadata->property = new \ReflectionProperty($obj, 'explicit');
        $metadata->type = new Object_();
        $metadata->annotations = $this->createMock(AnnotationCollection::class);
        $metadata->configuration = new FakeMockField();
        $metadata->objectConfiguration = new FakeMock();

        $generator = new ClassMapper();
        $result = $generator->getObjectForField($metadata);

        $this->assertNull($result);
    }

    public function testNonExistingMappingTarget()
    {
        $obj = new Recursive();

        $metadata = new FieldMetadata();
        $metadata->object = $obj;
        $metadata->property = new \ReflectionProperty($obj, 'explicit');
        $metadata->type = new Object_(new Fqsen('\stdClass'));
        $metadata->annotations = $this->createMock(AnnotationCollection::class);
        $metadata->configuration = new FakeMockField();
        $metadata->objectConfiguration = new FakeMock();

        $generator = new ClassMapper();
        $generator->addClassMapping('stdClass', 'Szczebrzeszyn');

        $this->expectException(\InvalidArgumentException::class);
        $generator->getObjectForField($metadata);
    }

    public function testMappingTargetNotRelatedToType()
    {
        $obj = new Recursive();

        $metadata = new FieldMetadata();
        $metadata->object = $obj;
        $metadata->property = new \ReflectionProperty($obj, 'explicit');
        $metadata->type = new Object_(new Fqsen('\Tests\Er1z\FakeMock\Mocks\Struct\ExplicitInterface'));
        $metadata->annotations = $this->createMock(AnnotationCollection::class);
        $metadata->configuration = new FakeMockField();
        $metadata->objectConfiguration = new FakeMock();

        $generator = new ClassMapper();
        $generator->addClassMapping(ExplicitInterface::class, \stdClass::class);

        $this->expectException(\InvalidArgumentException::class);
        $generator->getObjectForField($metadata);
    }


}