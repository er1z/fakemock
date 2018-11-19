<?php

namespace Tests\Er1z\FakeMock\Decorator\AssertDecorator;

use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Decorator\AssertDecorator\NotIdenticalTo;
use Er1z\FakeMock\Metadata\FieldMetadata;
use phpDocumentor\Reflection\Types\String_;
use PHPUnit\Framework\TestCase;
use Tests\Er1z\FakeMock\AssertsTestTrait;

class NotIdenticalToTest extends TestCase
{
    use AssertsTestTrait;

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

        $metadata = new FieldMetadata();
        $metadata->object = $obj;
        $metadata->property = new \ReflectionProperty($obj, 'second');
        $metadata->type = new String_();
        $metadata->annotations = $this->createMock(AnnotationCollection::class);
        $metadata->configuration = new FakeMockField();
        $metadata->objectConfiguration = new FakeMock();

        $decorator = new NotIdenticalTo();

        $str = 'one';

        $result = $decorator->decorate($str, $metadata, new \Symfony\Component\Validator\Constraints\NotIdenticalTo([
            'propertyPath' => 'first',
        ]));

        $this->assertTrue($result);
        $this->assertNotEquals('one', $str);
    }
}
