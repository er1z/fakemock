<?php


namespace Tests\Er1z\FakeMock\Generator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Generator\TypedGenerator;
use PHPUnit\Framework\TestCase;

class TypedGeneratorTest extends TestCase
{


    const TESTING_SCALAR_VALUE = 'testing scalar value';

    protected function getInternalResult($data, $description){
        $generator = new TypedGenerator();

        $config = new FakeMockField($data);

        $obj = new \stdClass();
        $obj->sth = true;

        $prop = new \ReflectionProperty($obj, 'sth');

        $result = $generator->generateForProperty(new \stdClass(), $prop, $config, $this->createMock(AnnotationCollection::class), $description);
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