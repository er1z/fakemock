<?php

namespace Tests\Er1z\FakeMock\Metadata;

use Doctrine\Common\Annotations\Reader;
use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Metadata\Factory;
use Er1z\FakeMock\Metadata\FieldMetadata;
use phpDocumentor\Reflection\Types\Float_;
use phpDocumentor\Reflection\Types\String_;
use PHPUnit\Framework\TestCase;
use Tests\Er1z\FakeMock\Mocks\Struct\Explicit;
use Tests\Er1z\FakeMock\Mocks\Struct\PhpDocTypes;

/**
 * Class FactoryTest.
 */
class FactoryTest extends TestCase
{
    public function testGetObjectConfiguration()
    {
        $reader = $this->createMock(Reader::class);

        $reader->expects($this->once())
            ->method('getClassAnnotation')
            ->willReturn(
                new FakeMock([
                    'useAsserts' => false,
                ])
            );

        $factory = new Factory($reader);
        $result = $factory->getObjectConfiguration(new \ReflectionClass(\stdClass::class));

        $this->assertInstanceOf(FakeMock::class, $result);
        $this->assertFalse($result->useAsserts);
    }

    public function testGetPhpDocType()
    {
        $factory = new Factory();

        $mock = new PhpDocTypes();
        $fieldWithType = new \ReflectionProperty($mock, 'withType');
        $fieldWithoutType = new \ReflectionProperty($mock, 'withoutType');
        $fieldNoDocBlock = new \ReflectionProperty($mock, 'docBlockWithoutVar');

        $method = new \ReflectionMethod($factory, 'getPhpDocType');
        $method->setAccessible(true);

        $withTypeResult = $method->invoke($factory, $fieldWithType);
        $withoutTypeResult = $method->invoke($factory, $fieldWithoutType);
        $noDocBlock = $method->invoke($factory, $fieldNoDocBlock);

        $this->assertInstanceOf(Float_::class, $withTypeResult);
        $this->assertNull($withoutTypeResult);
        $this->assertNull($noDocBlock);
    }

    public function testMergeGlobalConfigurationWithLocal()
    {
        $factory = new Factory();

        $method = new \ReflectionMethod($factory, 'mergeGlobalConfigurationWithLocal');
        $method->setAccessible(true);

        $global = new FakeMock();
        $global->useAsserts = false;
        $global->satisfyAssertsConditions = false;

        $localInherited = new FakeMockField();

        $localOverrided = new FakeMockField();
        $localOverrided->useAsserts = true;
        $localOverrided->satisfyAssertsConditions = true;

        /**
         * @var FakeMockField
         */
        $mergedInherited = $method->invoke($factory, $global, $localInherited);
        $this->assertFalse($mergedInherited->satisfyAssertsConditions);
        $this->assertFalse($mergedInherited->useAsserts);

        /**
         * @var FakeMockField
         */
        $mergedOverrided = $method->invoke($factory, $global, $localOverrided);
        $this->assertTrue($mergedOverrided->satisfyAssertsConditions);
        $this->assertTrue($mergedOverrided->useAsserts);
    }

    public function testCreateUnbound()
    {
        $factory = new Factory();
        $obj = new PhpDocTypes();

        $global = new FakeMock();

        $prop = new \ReflectionProperty($obj, 'withType');

        $result = $factory->create($obj, $global, $prop);

        $this->assertNull($result);
    }

    public function testCreateBound()
    {
        $factory = new Factory();

        $obj = new Explicit();

        $global = new FakeMock();
        $prop = new \ReflectionProperty($obj, 'value');

        $result = $factory->create($obj, $global, $prop);

        $this->assertInstanceOf(AnnotationCollection::class, $result[0]->annotations);
        $this->assertNotEmpty($result[0]->annotations->findAllBy(FakeMockField::class));
        $this->assertInstanceOf(FakeMockField::class, $result[0]->configuration);
        $this->assertInstanceOf(\ReflectionProperty::class, $result[0]->property);
        $this->assertInstanceOf(String_::class, $result[0]->type);
        $this->assertInstanceOf(FakeMock::class, $result[0]->objectConfiguration);
        $this->assertInstanceOf(Explicit::class, $result[0]->object);
    }

    public function testGetConfigurationForFieldByGroup()
    {
        $annotationsList = [
            new FieldMetadata(['configuration' => new FakeMockField(['groups' => ['nope']])]),
            new FieldMetadata(['configuration' => new FakeMockField(['groups' => ['yep']])]),
            new FieldMetadata(['configuration' => new FakeMockField(['groups' => ['why']])]),
        ];

        $factory = new Factory();

        /**
         * @var $result FieldMetadata
         */
        $result = $factory->getConfigurationForFieldByGroup($annotationsList, 'yep');
        $this->assertInstanceOf(FieldMetadata::class, $result);
        $this->assertTrue(in_array('yep', $result->configuration->groups));
    }

    public function testGetConfigurationForFieldByGroupEmptyFieldsList()
    {
        $factory = new Factory();

        /**
         * @var $result FieldMetadata
         */
        $result = $factory->getConfigurationForFieldByGroup([], 'yep');
        $this->assertNull($result);
    }

    public function testGetConfigurationForFieldByGroupWithEmptyArgument()
    {
        $annotationsList = [
            new FieldMetadata(['configuration' => new FakeMockField(['groups' => ['nope']])]),
            new FieldMetadata(['configuration' => new FakeMockField(['groups' => ['yep']])]),
            new FieldMetadata(['configuration' => new FakeMockField(['groups' => ['why']])]),
        ];

        $factory = new Factory();

        /**
         * @var $result FieldMetadata
         */
        $result = $factory->getConfigurationForFieldByGroup($annotationsList);
        $this->assertInstanceOf(FieldMetadata::class, $result);
        $this->assertTrue(in_array('nope', $result->configuration->groups));
    }
}
