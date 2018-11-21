<?php

namespace Tests\Er1z\FakeMock\Decorator;

use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Metadata\FieldMetadata;
use phpDocumentor\Reflection\Types\Boolean;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\String_;
use PHPUnit\Framework\TestCase;

class PhpDocDecorator extends TestCase
{
    public function testSkip()
    {
        $d = new \Er1z\FakeMock\Decorator\PhpDocDecorator();

        $obj = new \stdClass();
        $obj->test = null;

        $prop = new \ReflectionProperty($obj, 'test');

        $field = new FieldMetadata();
        $field->object = $obj;
        $field->property = $prop;
        $field->annotations = $this->createMock(AnnotationCollection::class);
        $field->configuration = new FakeMockField();
        $field->objectConfiguration = new FakeMock();

        $val = 'asd';

        $result = $d->decorate($val, $field);

        $this->assertTrue($result);
        $this->assertEquals('asd', $val);
    }

    public function testScalars()
    {
        $d = new \Er1z\FakeMock\Decorator\PhpDocDecorator();

        $obj = new \stdClass();
        $obj->test = null;

        $prop = new \ReflectionProperty($obj, 'test');

        $field = new FieldMetadata();
        $field->object = $obj;
        $field->property = $prop;
        $field->type = new Integer();
        $field->annotations = $this->createMock(AnnotationCollection::class);
        $field->configuration = new FakeMockField();
        $field->objectConfiguration = new FakeMock();

        $val = 10.01;

        $result = $d->decorate($val, $field);

        $this->assertInternalType('integer', $val);
        $this->assertEquals(10, $val);
        $this->assertTrue($result);
    }

    public function testToString()
    {
        $d = new \Er1z\FakeMock\Decorator\PhpDocDecorator();

        $obj = new \stdClass();
        $obj->test = null;

        $prop = new \ReflectionProperty($obj, 'test');

        $field = new FieldMetadata();
        $field->object = $obj;
        $field->property = $prop;
        $field->type = new String_();
        $field->annotations = $this->createMock(AnnotationCollection::class);
        $field->configuration = new FakeMockField();
        $field->objectConfiguration = new FakeMock();

        $val = 10.01;

        $result = $d->decorate($val, $field);

        $this->assertInternalType('string', $val);
        $this->assertEquals('10.01', $val);
        $this->assertTrue($result);
    }

    public function testBoolFromString()
    {
        $d = new \Er1z\FakeMock\Decorator\PhpDocDecorator();

        $obj = new \stdClass();
        $obj->test = null;

        $prop = new \ReflectionProperty($obj, 'test');

        $field = new FieldMetadata();
        $field->object = $obj;
        $field->property = $prop;
        $field->type = new Boolean();
        $field->annotations = $this->createMock(AnnotationCollection::class);
        $field->configuration = new FakeMockField();
        $field->objectConfiguration = new FakeMock();

        $val = 'false';

        $result = $d->decorate($val, $field);

        $this->assertInternalType('boolean', $val);
        $this->assertFalse($val);
        $this->assertTrue($result);

        $val = 0;

        $result = $d->decorate($val, $field);

        $this->assertInternalType('boolean', $val);
        $this->assertFalse($val);
        $this->assertTrue($result);

        $val = 'true';
        $result = $d->decorate($val, $field);

        $this->assertInternalType('boolean', $val);
        $this->assertTrue($val);
        $this->assertTrue($result);

        $result = $d->decorate($val, $field);

        $this->assertInternalType('boolean', $val);
        $this->assertTrue($val);
        $this->assertTrue($result);
    }

    public function testBoolToString()
    {
        $d = new \Er1z\FakeMock\Decorator\PhpDocDecorator();

        $obj = new \stdClass();
        $obj->test = null;

        $prop = new \ReflectionProperty($obj, 'test');

        $field = new FieldMetadata();
        $field->object = $obj;
        $field->property = $prop;
        $field->type = new String_();
        $field->annotations = $this->createMock(AnnotationCollection::class);
        $field->configuration = new FakeMockField();
        $field->object = new FakeMock();

        $val = true;

        $result = $d->decorate($val, $field);

        $this->assertInternalType('string', $val);
        $this->assertEquals('true', $val);
        $this->assertTrue($result);

        $val = false;

        $result = $d->decorate($val, $field);

        $this->assertInternalType('string', $val);
        $this->assertEquals('false', $val);
        $this->assertTrue($result);
    }

    public function testDatetime()
    {
        $d = new \Er1z\FakeMock\Decorator\PhpDocDecorator();

        $obj = new \stdClass();
        $obj->test = null;

        $prop = new \ReflectionProperty($obj, 'test');

        $field = new FieldMetadata();
        $field->object = $obj;
        $field->property = $prop;
        $field->type = new String_();
        $field->annotations = $this->createMock(AnnotationCollection::class);
        $field->configuration = new FakeMockField();
        $field->objectConfiguration = new FakeMock();

        $val = new \DateTime();

        $result = $d->decorate($val, $field);

        $this->assertInternalType('string', $val);
        $this->assertGreaterThan(0, strtotime($val));
        $this->assertTrue($result);
    }
}
