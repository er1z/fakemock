<?php

namespace Tests\Er1z\FakeMock\Decorator\AssertDecorator;

use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Decorator\AssertDecorator\LessThan;
use Er1z\FakeMock\Metadata\FieldMetadata;
use phpDocumentor\Reflection\Types\Float_;
use phpDocumentor\Reflection\Types\Integer;
use PHPUnit\Framework\TestCase;
use Tests\Er1z\FakeMock\AssertsTestTrait;

class LessThanTest extends TestCase
{
    use AssertsTestTrait;

    public function testWithoutNumericValue()
    {
        $decorator = new LessThan();

        $num = 'asdasd';
        $this->expectException(\InvalidArgumentException::class);

        $decorator->decorate($num, $this->createMock(FieldMetadata::class), new \Symfony\Component\Validator\Constraints\LessThan([
            'value' => 10,
        ]));
    }

    public function testWithoutPropertyNumericValue()
    {
        $obj = new \stdClass();
        $obj->test = ['asd'];

        $fieldMetadata = new FieldMetadata();
        $fieldMetadata->object = $obj;
        $fieldMetadata->property = new \ReflectionProperty($obj, 'test');
        $fieldMetadata->type = new Float_();
        $fieldMetadata->annotations = $this->createMock(AnnotationCollection::class);
        $fieldMetadata->configuration = new FakeMockField();
        $fieldMetadata->objectConfiguration = new FakeMock();

        $num = 10.0;

        $decorator = new LessThan();

        $this->expectException(\InvalidArgumentException::class);

        $decorator->decorate($num, $fieldMetadata, new \Symfony\Component\Validator\Constraints\LessThan([
            'propertyPath' => 'test',
        ]));
    }

    public function testScalarValueInt()
    {
        $decorator = new LessThan();

        $num = 10;

        $decorator->decorate($num, $this->createMock(FieldMetadata::class), new \Symfony\Component\Validator\Constraints\LessThan([
            'value' => 10,
        ]));

        $this->assertLessThan(10, $num);

        $num = 11;
        $decorator->decorate($num, $this->createMock(FieldMetadata::class), new \Symfony\Component\Validator\Constraints\LessThan([
            'value' => 10,
        ]));

        $this->assertLessThan(10, $num);
    }

    public function testScalarValueFloat()
    {
        $decorator = new LessThan();

        $obj = new \stdClass();
        $obj->test = null;

        $fieldMetadata = new FieldMetadata();
        $fieldMetadata->object = $obj;
        $fieldMetadata->property = new \ReflectionProperty($obj, 'test');
        $fieldMetadata->type = new Float_();
        $fieldMetadata->annotations = $this->createMock(AnnotationCollection::class);
        $fieldMetadata->configuration = new FakeMockField();
        $fieldMetadata->objectConfiguration = new FakeMock();

        $num = 10.01;

        $decorator->decorate($num, $fieldMetadata, new \Symfony\Component\Validator\Constraints\LessThan([
            'value' => 10.01,
        ]));

        $this->assertLessThan(10.01, $num);

        $num = 10.1;
        $decorator->decorate($num, $fieldMetadata, new \Symfony\Component\Validator\Constraints\LessThan([
            'value' => 10.01,
        ]));

        $this->assertLessThan(10.01, $num);
    }

    public function testPropertyPathInt()
    {
        $decorator = new LessThan();

        $num = 10;

        $obj = new \stdClass();
        $obj->test = 10;

        $fieldMetadata = new FieldMetadata();
        $fieldMetadata->object = $obj;
        $fieldMetadata->property = new \ReflectionProperty($obj, 'test');
        $fieldMetadata->type = new Integer();
        $fieldMetadata->annotations = $this->createMock(AnnotationCollection::class);
        $fieldMetadata->configuration = new FakeMockField();
        $fieldMetadata->objectConfiguration = new FakeMock();

        $decorator->decorate($num, $fieldMetadata, new \Symfony\Component\Validator\Constraints\LessThan([
            'propertyPath' => 'test',
        ]));

        $this->assertLessThan(10, $num);

        $obj = new \stdClass();
        $obj->test = 10;

        $fieldMetadata = new FieldMetadata();
        $fieldMetadata->object = $obj;
        $fieldMetadata->property = new \ReflectionProperty($obj, 'test');
        $fieldMetadata->type = new Integer();
        $fieldMetadata->annotations = $this->createMock(AnnotationCollection::class);
        $fieldMetadata->configuration = new FakeMockField();
        $fieldMetadata->objectConfiguration = new FakeMock();

        $num = 11;
        $decorator->decorate($num, $fieldMetadata, new \Symfony\Component\Validator\Constraints\LessThan([
            'propertyPath' => 'test',
        ]));

        $this->assertLessThan(10, $num);
    }

    public function testPropertyPathFloat()
    {
        $decorator = new LessThan();

        $num = 10.01;

        $obj = new \stdClass();
        $obj->test = 10.01;

        $fieldMetadata = new FieldMetadata();
        $fieldMetadata->object = $obj;
        $fieldMetadata->property = new \ReflectionProperty($obj, 'test');
        $fieldMetadata->type = new Float_();
        $fieldMetadata->annotations = $this->createMock(AnnotationCollection::class);
        $fieldMetadata->configuration = new FakeMockField();
        $fieldMetadata->objectConfiguration = new FakeMock();

        $decorator->decorate($num, $fieldMetadata, new \Symfony\Component\Validator\Constraints\LessThan([
            'propertyPath' => 'test',
        ]));

        $this->assertLessThan(10.01, $num);

        $obj = new \stdClass();
        $obj->test = 10.01;

        $fieldMetadata = new FieldMetadata();
        $fieldMetadata->object = $obj;
        $fieldMetadata->property = new \ReflectionProperty($obj, 'test');
        $fieldMetadata->type = new Float_();
        $fieldMetadata->annotations = $this->createMock(AnnotationCollection::class);
        $fieldMetadata->configuration = new FakeMockField();
        $fieldMetadata->objectConfiguration = new FakeMock();

        $num = 11.0;
        $decorator->decorate($num, $fieldMetadata, new \Symfony\Component\Validator\Constraints\LessThan([
            'propertyPath' => 'test',
        ]));

        $this->assertLessThan(10.01, $num);
    }
}
