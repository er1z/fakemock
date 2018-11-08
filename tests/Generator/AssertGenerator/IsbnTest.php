<?php


namespace Tests\Er1z\FakeMock\Generator\AssertGenerator;


use Er1z\FakeMock\Generator\AssertGenerator\Isbn;
use Symfony\Component\Validator\Constraints\Length;

class IsbnTest extends GeneratorAbstractTest
{

    public function testIsbn10()
    {
        $generator = new Isbn();

        $field = $this->getFieldMetadata();

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\Isbn(),
            $this->getFaker()
        );

        $this->assertTrue(ctype_alnum($value));
        $this->assertEquals(10, strlen($value));
    }

    public function testIsbn13()
    {
        $generator = new Isbn();

        $field = $this->getFieldMetadata([
            new Length(['max'=>13])
        ]);

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\Isbn(),
            $this->getFaker()
        );

        $this->assertTrue(ctype_alnum($value));
        $this->assertEquals(13, strlen($value));
    }

}