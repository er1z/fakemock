<?php


namespace Tests\Er1z\FakeMock\Generator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\FieldMetadata;
use Er1z\FakeMock\Generator\TypedGenerator;
use phpDocumentor\Reflection\Type;
use PHPUnit\Framework\TestCase;

class TypedGeneratorTest extends TestCase
{

    const TESTING_SCALAR_VALUE = 'testing scalar value';

    protected function getInternalResult($data){
        $generator = new TypedGenerator();

        $config = new FakeMockField($data);

        $obj = new \stdClass();
        $obj->sth = true;

        $prop = new \ReflectionProperty($obj, 'sth');

        $field = new FieldMetadata(
            $obj,
            $prop,
            $this->createMock(Type::class),
            $this->createMock(AnnotationCollection::class),
            $config
        );

        $result = $generator->generateForProperty($field);
        return $result;
    }

    public function testScalarValue()
    {
        $result = $this->getInternalResult([
            'value'=> self::TESTING_SCALAR_VALUE
        ], 'Scalar value');

        $this->assertEquals(self::TESTING_SCALAR_VALUE, $result);
    }

    public function testRegexValue()
    {
        $result = $this->getInternalResult([
            'regex'=> '\d{7}'
        ], 'Regex value');

        $this->assertGreaterThanOrEqual('1000000', $result);
    }


}