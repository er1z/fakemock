<?php

namespace Tests\Er1z\FakeMock\Decorator;

use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Decorator\DecoratorAbstract;
use Er1z\FakeMock\Metadata\FieldMetadata;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Url;
use Tests\Er1z\FakeMock\AssertsTestTrait;
use Tests\Er1z\FakeMock\Mocks\AssertDecoratorMockNegative;
use Tests\Er1z\FakeMock\Mocks\AssertDecoratorMockPositive;

class DecoratorAbstractTest extends TestCase
{
    use AssertsTestTrait {
        setUp as setUp_;
    }

    protected $counter = 0;

    protected function setUp()
    {
        $this->counter = 0;
        parent::setUp();
        $this->setUp_();
    }

    public function testDecorateSingle()
    {
        $mock = $this->getMockForAbstractClass(DecoratorAbstract::class);

        $mock->expects($this->once())->method('getDecoratorFqcn')->willReturn(AssertDecoratorMockPositive::class);

        $test = null;
        $obj = new \stdClass();
        $obj->field = null;
        $field = new FieldMetadata();
        $field->object = $obj;
        $field->property = new \ReflectionProperty($obj, 'field');
        $field->annotations = new AnnotationCollection([
            new Email(),
        ]);
        $field->configuration = new FakeMockField();

        $result = $mock->decorate($test, $field);

        $this->assertTrue($result);
        $this->assertEquals(AssertDecoratorMockPositive::MOCK_VALUE, $test);
    }

    public function collectionFqcns()
    {
        if (0 == $this->counter) {
            $result = AssertDecoratorMockNegative::class;
        } else {
            $result = AssertDecoratorMockPositive::class;
        }

        ++$this->counter;

        return $result;
    }

    public function testDecorateCollectionWithBreak()
    {
        $mock = $this->getMockForAbstractClass(DecoratorAbstract::class);

        $mock->expects($this->once())->method('getDecoratorFqcn')->will($this->returnCallback([$this, 'collectionFqcns']));

        $test = null;
        $obj = new \stdClass();
        $obj->field = null;

        $field = new FieldMetadata();
        $field->object = $obj;
        $field->property = new \ReflectionProperty($obj, 'field');
        $field->annotations = new AnnotationCollection([
            new Email(),
            new Url(),
        ]);
        $field->configuration = new FakeMockField();

        $result = $mock->decorate($test, $field);

        $this->assertTrue($result);
        $this->assertEquals(AssertDecoratorMockNegative::MOCK_VALUE, $test);
    }
}
