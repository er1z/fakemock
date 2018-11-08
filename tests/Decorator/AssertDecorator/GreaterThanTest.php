<?php


namespace Tests\Er1z\FakeMock\Decorator\AssertDecorator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Decorator\AssertDecorator\GreaterThan;
use Er1z\FakeMock\Metadata\FieldMetadata;
use phpDocumentor\Reflection\Types\Float_;
use phpDocumentor\Reflection\Types\Integer;
use PHPUnit\Framework\TestCase;

class GreaterThanTest extends TestCase
{

    public function testWithoutNumericValue()
    {
        $decorator = new GreaterThan();

        $num = 'asdasd';
        $this->expectException(\InvalidArgumentException::class);

        $decorator->decorate($num, $this->createMock(FieldMetadata::class), new \Symfony\Component\Validator\Constraints\GreaterThan([
            'value'=>10
        ]));
    }

    public function testWithoutPropertyNumericValue()
    {
        $obj = new \stdClass();
        $obj->test = ['asd'];

        $fieldMetadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'test'),
            new Float_(),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField()
        );

        $num = 10.01;

        $decorator = new GreaterThan();

        $this->expectException(\InvalidArgumentException::class);

        $decorator->decorate($num, $fieldMetadata, new \Symfony\Component\Validator\Constraints\GreaterThan([
            'propertyPath'=>'test'
        ]));
    }

    public function testScalarValueInt()
    {
        $decorator = new GreaterThan();

        $num = 9;

        $decorator->decorate($num, $this->createMock(FieldMetadata::class), new \Symfony\Component\Validator\Constraints\GreaterThan([
            'value'=>10
        ]));

        $this->assertGreaterThan(10, $num);

        $num = 9;
        $decorator->decorate($num, $this->createMock(FieldMetadata::class), new \Symfony\Component\Validator\Constraints\GreaterThan([
            'value'=>10
        ]));

        $this->assertGreaterThan(10, $num);

    }

    public function testScalarValueFloat()
    {
        $decorator = new GreaterThan();

        $obj = new \stdClass();
        $obj->test = null;

        $fieldMetadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'test'),
            new Float_(),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField()
        );

        $num = 9.01;

        $decorator->decorate($num, $fieldMetadata, new \Symfony\Component\Validator\Constraints\GreaterThan([
            'value'=>10.01
        ]));

        $this->assertGreaterThan(10, $num);

        $num = 9.9;
        $decorator->decorate($num, $fieldMetadata, new \Symfony\Component\Validator\Constraints\GreaterThan([
            'value'=>10.01
        ]));

        $this->assertGreaterThan(10.01, $num);

    }

    public function testPropertyPathInt()
    {
        $decorator = new GreaterThan();

        $num = 9;

        $obj = new \stdClass();
        $obj->test = 10;

        $fieldMetadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'test'),
            new Integer(),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField()
        );

        $decorator->decorate($num, $fieldMetadata, new \Symfony\Component\Validator\Constraints\GreaterThan([
            'propertyPath'=>'test'
        ]));

        $this->assertGreaterThan(10, $num);

        $obj = new \stdClass();
        $obj->test = 10;

        $fieldMetadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'test'),
            new Integer(),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField()
        );

        $num = 11;
        $decorator->decorate($num, $fieldMetadata, new \Symfony\Component\Validator\Constraints\GreaterThan([
            'propertyPath'=>'test'
        ]));

        $this->assertGreaterThan(10, $num);

    }

    public function testPropertyPathFloat()
    {
        $decorator = new GreaterThan();

        $num = 10.01;

        $obj = new \stdClass();
        $obj->test = 10.01;

        $fieldMetadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'test'),
            new Float_(),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField()
        );

        $decorator->decorate($num, $fieldMetadata, new \Symfony\Component\Validator\Constraints\GreaterThan([
            'propertyPath'=>'test'
        ]));

        $this->assertGreaterThan(10.01, $num);

        $obj = new \stdClass();
        $obj->test = 10.01;

        $fieldMetadata = new FieldMetadata(
            $obj,
            new \ReflectionProperty($obj, 'test'),
            new Float_(),
            $this->createMock(AnnotationCollection::class),
            new FakeMockField()
        );

        $num = 9.01;
        $decorator->decorate($num, $fieldMetadata, new \Symfony\Component\Validator\Constraints\GreaterThan([
            'propertyPath'=>'test'
        ]));

        $this->assertGreaterThan(10.01, $num);

    }

}