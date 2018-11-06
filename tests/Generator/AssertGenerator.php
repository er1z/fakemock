<?php


namespace Tests\Er1z\FakeMock\Generator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\FieldMetadata;
use phpDocumentor\Reflection\Type;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\Email;

class AssertGenerator extends TestCase
{

    public function testEmail()
    {
        $obj = new \stdClass();
        $obj->mail = null;

        $prop = new \ReflectionProperty($obj, 'mail');

        $field = new FieldMetadata(
            $obj,
            $prop,
            $this->createMock(Type::class),
            new AnnotationCollection([
                new Email()
            ]),
            new FakeMockField()
        );

        $assertGenerator = new \Er1z\FakeMock\Generator\AssertGenerator();
        $value = $assertGenerator->generateForProperty($field);

        $this->assertNotNull(
            filter_var($value, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE)
        );
    }

}