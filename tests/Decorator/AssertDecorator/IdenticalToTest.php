<?php

namespace Tests\Er1z\FakeMock\Decorator\AssertDecorator;

use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Decorator\AssertDecorator\IdenticalTo;
use Er1z\FakeMock\Metadata\FieldMetadata;
use phpDocumentor\Reflection\Types\String_;
use PHPUnit\Framework\TestCase;
use Tests\Er1z\FakeMock\AssertsTestTrait;

class IdenticalToTest extends TestCase
{
    use AssertsTestTrait;

    public function testWithScalarValue()
    {
        $decorator = new IdenticalTo();

        $result = $decorator->decorate($str, $this->createMock(FieldMetadata::class), new \Symfony\Component\Validator\Constraints\IdenticalTo([
            'value' => 'three',
        ]));

        $this->assertTrue($result);
        $this->assertEquals('three', $str);
    }

    public function testWithPath()
    {
        $obj = new \stdClass();
        $obj->first = 'one';
        $obj->second = 'two';

        $metadata = new FieldMetadata();
        $metadata->object = $obj;
        $metadata->property = new \ReflectionProperty($obj, 'second');
        $metadata->type = new String_();
        $metadata->annotations = $this->createMock(AnnotationCollection::class);
        $metadata->configuration = new FakeMockField();
        $metadata->objectConfiguration = new FakeMock();

        $decorator = new IdenticalTo();

        $result = $decorator->decorate($str, $metadata, new \Symfony\Component\Validator\Constraints\IdenticalTo([
            'propertyPath' => 'first',
        ]));

        $this->assertTrue($result);
        $this->assertEquals('one', $str);
    }
}
