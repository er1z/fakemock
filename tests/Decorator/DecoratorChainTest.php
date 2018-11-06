<?php


namespace Tests\Er1z\FakeMock\Decorator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Decorator\DecoratorChain;
use Er1z\FakeMock\Decorator\DecoratorInterface;
use Er1z\FakeMock\FieldMetadata;
use phpDocumentor\Reflection\Type;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraint;

class DecoratorChainTest extends TestCase
{
    public function testDefaultGeneratorsSet()
    {
        $constraintsAvail = class_exists(Constraint::class);

        $decorators = DecoratorChain::getDefaultDecoratorsSet();

        $this->assertCount($constraintsAvail ? 1 : 0, $decorators, 'Count ok');

        foreach($decorators as $g){
            $this->assertInstanceOf(DecoratorInterface::class, $g, get_class($g));
        }
    }

    public function testRunOnlyFirstDecorator(){
        $firstDecorator = $this
            ->getMockBuilder(DecoratorInterface::class)
            ->getMock();

        $firstDecorator
            ->expects($this->once())
            ->method('decorate')->willReturn(false);

        $secondDecorator = $this
            ->getMockBuilder(DecoratorInterface::class)->getMock();

        $secondDecorator
            ->expects($this->never())
            ->method('decorate');

        $decoratorChain = new DecoratorChain([
            $firstDecorator,
            $secondDecorator
        ]);

        $obj = new \stdClass();
        $obj->field = 'test';

        $prop = new \ReflectionProperty($obj, 'field');

        $field = new FieldMetadata(
            $obj,
            $prop,
            $this->createMock(Type::class),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField()
        );

        $decoratorChain->getDecoratedValue('', $field);

    }

    public function testCallWithNoArguments()
    {
        $obj = new DecoratorChain();

        $refl = new \ReflectionClass($obj);
        $prop = $refl->getProperty('decorators');
        $prop->setAccessible(true);

        $this->assertNotEmpty($prop->getValue($obj));
    }
}