<?php

namespace Tests\Er1z\FakeMock\Decorator\AssertDecorator;

use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Decorator\AssertDecorator\NotIdenticalTo;
use Er1z\FakeMock\Metadata\FieldMetadata;
use phpDocumentor\Reflection\Types\String_;
use PHPUnit\Framework\TestCase;

class NotIdenticalToTest extends TestCase
{
    public function testWithScalarValue()
    {
        $decorator = new NotIdenticalTo();

        $str = $oldStr = 'three';

        $result = $decorator->decorate($str, $this->createMock(FieldMetadata::class), new \Symfony\Component\Validator\Constraints\NotIdenticalTo([
            'value' => $oldStr,
        ]));

        $this->assertTrue($result);
        $this->assertNotEquals($oldStr, $str);
    }

    public function testWithSomethingWeird()
    {
        $decorator = new NotIdenticalTo();

        $val = [];

        $this->expectException(\InvalidArgumentException::class);

        $decorator->decorate($val, $this->createMock(FieldMetadata::class), new \Symfony\Component\Validator\Constraints\NotIdenticalTo([
            'value' => 'test',
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

        $decorator = new NotIdenticalTo();

        $str = 'one';

        $result = $decorator->decorate($str, $metadata, new \Symfony\Component\Validator\Constraints\NotIdenticalTo([
            'propertyPath' => 'first',
        ]));

        $this->assertTrue($result);
        $this->assertNotEquals('one', $str);
    }
}
