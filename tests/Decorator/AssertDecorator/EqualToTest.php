<?php

namespace Tests\Er1z\FakeMock\Decorator\AssertDecorator;

use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Decorator\AssertDecorator\EqualTo;
use Er1z\FakeMock\Metadata\FieldMetadata;
use phpDocumentor\Reflection\Types\String_;
use PHPUnit\Framework\TestCase;
use Tests\Er1z\FakeMock\AssertsTestTrait;

class EqualToTest extends TestCase
{
    use AssertsTestTrait;

    public function testWithScalarValue()
    {
        $decorator = new EqualTo();

        $result = $decorator->decorate($str, $this->createMock(FieldMetadata::class), new \Symfony\Component\Validator\Constraints\EqualTo([
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

        $metadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'second'),
            new String_(),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField()
        );

        $decorator = new EqualTo();

        $result = $decorator->decorate($str, $metadata, new \Symfony\Component\Validator\Constraints\EqualTo([
            'propertyPath' => 'first',
        ]));

        $this->assertTrue($result);
        $this->assertEquals('one', $str);
    }
}
