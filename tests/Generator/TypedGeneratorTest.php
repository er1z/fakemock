<?php

namespace Tests\Er1z\FakeMock\Generator;

use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\FakeMock;
use Er1z\FakeMock\Metadata\FieldMetadata;
use Er1z\FakeMock\Generator\TypedGenerator;
use phpDocumentor\Reflection\Type;
use PHPUnit\Framework\TestCase;

class TypedGeneratorTest extends TestCase
{
    const TESTING_SCALAR_VALUE = 'testing scalar value';

    protected function getInternalResult($data)
    {
        $generator = new TypedGenerator();

        $config = new FakeMockField($data);

        $obj = new \stdClass();
        $obj->sth = true;

        $prop = new \ReflectionProperty($obj, 'sth');

        $field = new FieldMetadata();
        $field->object = $obj;
        $field->property = $prop;
        $field->type = $this->createMock(Type::class);
        $field->annotations = $this->createMock(AnnotationCollection::class);
        $field->configuration = $config;
        $field->objectConfiguration = new \Er1z\FakeMock\Annotations\FakeMock();

        $result = $generator->generateForProperty($field, $this->createMock(FakeMock::class));

        return $result;
    }

    public function testScalarValue()
    {
        $result = $this->getInternalResult([
            'value' => self::TESTING_SCALAR_VALUE,
        ]);

        $this->assertEquals(self::TESTING_SCALAR_VALUE, $result, 'Scalar value');
    }

    public function testRegexValue()
    {
        $result = $this->getInternalResult([
            'regex' => '\d{7}',
        ]);

        $this->assertGreaterThanOrEqual('1000000', $result, 'Regex value');
    }
}
