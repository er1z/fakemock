<?php

namespace Tests\Er1z\FakeMock\Generator;

use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\FakeMock as FakeMockAlias;
use Er1z\FakeMock\Faker\Registry;
use Er1z\FakeMock\Faker\RegistryInterface;
use Er1z\FakeMock\Metadata\FieldMetadata;
use Er1z\FakeMock\Generator\LastResortGenerator;
use Faker\Factory;
use Faker\Generator;
use phpDocumentor\Reflection\Type;
use PHPUnit\Framework\TestCase;

class LastResortGeneratorTest extends TestCase
{
    protected function runForProperty($generator = null)
    {
        $generator = new LastResortGenerator($generator);

        $obj = new \stdClass();
        $obj->sth = true;

        $prop = new \ReflectionProperty($obj, 'sth');

        $field = new FieldMetadata();
        $field->object = $obj;
        $field->property = $prop;
        $field->type = $this->createMock(Type::class);
        $field->annotations = $this->createMock(AnnotationCollection::class);
        $field->configuration = new FakeMockField();
        $field->objectConfiguration = new FakeMock();

        $result = $generator->generateForProperty($field, $this->createMock(FakeMockAlias::class));

        return $result;
    }

    public function testGenerate()
    {
        $result = $this->runForProperty();
        $this->assertGreaterThanOrEqual(2, explode(' ', $result), 'Generator not supplied');
    }

    public function testWithCustomGenerator()
    {
        $generator = $this->getMockBuilder(RegistryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $generator
            ->expects(
                $this->once()
            )
            ->method('getGeneratorForField')->willReturn(Factory::create());

        $this->runForProperty($generator);
    }
}
