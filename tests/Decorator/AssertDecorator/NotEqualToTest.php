<?php


namespace Tests\Er1z\FakeMock\Decorator\AssertDecorator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Decorator\AssertDecorator\EqualTo;
use Er1z\FakeMock\Decorator\AssertDecorator\NotEqualTo;
use Er1z\FakeMock\FieldMetadata;
use phpDocumentor\Reflection\Types\String_;
use PHPUnit\Framework\TestCase;

class NotEqualToTest extends TestCase
{

    public function testWithScalarValue()
    {
        $decorator = new NotEqualTo();

        $str = $oldStr = 'three';

        $result = $decorator->decorate($str, $this->createMock(FieldMetadata::class), new \Symfony\Component\Validator\Constraints\EqualTo([
            'value'=>$oldStr
        ]));

        $this->assertTrue($result);
        $this->assertNotEquals($oldStr, $str);
    }

    public function testWithSomethingWeird()
    {
        $decorator = new NotEqualTo();

        $val = [];

        $this->expectException(\InvalidArgumentException::class);

        $decorator->decorate($val, $this->createMock(FieldMetadata::class), new \Symfony\Component\Validator\Constraints\EqualTo([
            'value'=>'test'
        ]));

    }

    public function testWithPath()
    {
        $obj = new \stdClass();
        $obj->first = 'one';
        $obj->second = 'one';

        $metadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'second'),
            new String_(),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField()
        );

        $decorator = new NotEqualTo();

        $str = 'one';

        $result = $decorator->decorate($str, $metadata, new \Symfony\Component\Validator\Constraints\EqualTo([
            'propertyPath'=>'first'
        ]));

        $this->assertTrue($result);
        $this->assertNotEquals('one', $str);

    }

}