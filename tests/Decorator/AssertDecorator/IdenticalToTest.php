<?php


namespace Tests\Er1z\FakeMock\Decorator\AssertDecorator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Decorator\AssertDecorator\EqualTo;
use Er1z\FakeMock\Decorator\AssertDecorator\IdenticalTo;
use Er1z\FakeMock\FieldMetadata;
use phpDocumentor\Reflection\Types\String_;
use PHPUnit\Framework\TestCase;

class IdenticalToTest extends TestCase
{

    public function testWithScalarValue()
    {
        $decorator = new IdenticalTo();

        $result = $decorator->decorate($str, $this->createMock(FieldMetadata::class), new \Symfony\Component\Validator\Constraints\IdenticalTo([
            'value'=>'three'
        ]));

        $this->assertTrue($result);
        $this->assertEquals('three', $str);
    }

    public function testWithPath()
    {
        $obj = new \stdClass();
        $obj->first = 'one';
        $obj->second = 'two';

        $metadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'second'),
            new String_(),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField()
        );

        $decorator = new IdenticalTo();

        $result = $decorator->decorate($str, $metadata, new \Symfony\Component\Validator\Constraints\IdenticalTo([
            'propertyPath'=>'first'
        ]));

        $this->assertTrue($result);
        $this->assertEquals('one', $str);

    }

}