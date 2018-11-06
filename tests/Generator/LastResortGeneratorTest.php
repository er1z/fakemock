<?php


namespace Tests\Er1z\FakeMock\Generator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Generator\LastResortGenerator;
use Er1z\FakeMock\Generator\TypedGenerator;
use Faker\Generator;
use PHPUnit\Framework\TestCase;

class LastResortGeneratorTest extends TestCase
{


    protected function runForProperty($generator = null){
        $generator = new LastResortGenerator($generator);

        $obj = new \stdClass();
        $obj->sth = true;

        $prop = new \ReflectionProperty($obj, 'sth');

        $result = $generator->generateForProperty(new \stdClass(), $prop, new FakeMockField([]), $this->createMock(AnnotationCollection::class));
        return $result;
    }

    public function testGenerate()
    {
        $result = $this->runForProperty();
        $this->assertGreaterThanOrEqual(2, explode(' ', $result), 'Generator not supplied');
    }

    public function testWithCustomGenerator(){
        $generator = $this->getMockBuilder(Generator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $generator
            ->expects(
                $this->once()
            )
            ->method('__call');

        $this->runForProperty($generator);

    }

}