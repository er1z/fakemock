<?php

namespace Tests\Er1z\FakeMock\Decorator;

use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Decorator\AssertDecorator;
use Er1z\FakeMock\Metadata\FieldMetadata;
use phpDocumentor\Reflection\Types\String_;
use PHPUnit\Framework\TestCase;
use Tests\Er1z\FakeMock\AssertsTestTrait;

class AssertDecoratorTest extends TestCase
{
    use AssertsTestTrait;

    public function testDecorateDisabledAssertConditions()
    {
        $d = new AssertDecorator();

        $val = null;
        $obj = new \stdClass();
        $obj->prop = null;
        $prop = new \ReflectionProperty($obj, 'prop');

        $field = new FieldMetadata();
        $field->object = $obj;
        $field->property = $prop;
        $field->type = new String_();
        $field->annotations = $this->createMock(AnnotationCollection::class);
        $field->configuration = new FakeMockField([
            'satisfyAssertsConditions' => false,
        ]);
        $field->objectConfiguration = new FakeMock();

        $result = $d->decorate($val, $field);

        $this->assertFalse($result);
    }

    public function testDecoratorFqcn()
    {
        $d = new AssertDecorator();
        $m = new \ReflectionMethod($d, 'getDecoratorFqcn');
        $m->setAccessible(true);

        $this->assertEquals('Er1z\\FakeMock\\Decorator\\AssertDecorator\\Test', $m->invoke($d, 'Test'));
    }
}
