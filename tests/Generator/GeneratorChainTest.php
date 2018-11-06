<?php


namespace Tests\Er1z\FakeMock\Generator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Generator\GeneratorChain;
use Er1z\FakeMock\Generator\GeneratorInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraint;

class GeneratorChainTest extends TestCase
{

    public function testDefaultGeneratorsSet()
    {
        $constraintsAvail = class_exists(Constraint::class);

        $generators = GeneratorChain::getDefaultDetectorsSet();

        $this->assertCount($constraintsAvail ? 4 : 3, $generators, 'Count ok');

        foreach($generators as $g){
            $this->assertInstanceOf(GeneratorInterface::class, $g, get_class($g));
        }
    }

    protected function generate($result = null){
        $generator = $this
            ->getMockBuilder(GeneratorInterface::class)
            ->getMock();

        $generator
            ->method('generateForProperty')
            ->willReturn($result);

        $generatorChain = new GeneratorChain([
            $generator
        ]);

        $obj = new \stdClass();
        $obj->field = 'test';

        $prop = new \ReflectionProperty($obj, 'field');

        $result = $generatorChain->getValueForField(
            $obj, $prop, new FakeMockField(), $this->createMock(AnnotationCollection::class)
        );

        return $result;
    }

    public function testNoGeneratorGenerates()
    {
        $result = $this->generate();
        $this->assertNull($result);
    }

    public function testSingleGenerator(){
        $result = $this->generate(true);
        $this->assertTrue($result);
    }

    public function testCallWithNoArguments()
    {
        $obj = new GeneratorChain();

        $refl = new \ReflectionClass($obj);
        $prop = $refl->getProperty('generators');
        $prop->setAccessible(true);

        $this->assertNotEmpty($prop->getValue($obj));
    }

}