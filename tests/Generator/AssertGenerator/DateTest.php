<?php


namespace Tests\Er1z\FakeMock\Generator\AssertGenerator;


use Er1z\FakeMock\Generator\AssertGenerator\Date;
use phpDocumentor\Reflection\Types\String_;

class DateTest extends GeneratorAbstractTest
{

    public function testDateAsObject()
    {
        $generator = new Date();

        $field = $this->getFieldMetadata();

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\Date(),
            $this->getFaker()
        );

        $this->assertInstanceOf(\DateTime::class, $value);
        $this->assertEquals('00:00:00', $value->format('H:i:s'));
    }

    public function testDateAsString()
    {
        $generator = new Date();

        $field = $this->getFieldMetadata([], new String_());

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\Date(),
            $this->getFaker()
        );

        $this->assertInternalType('string', $value);
        $this->assertRegExp('#\d{4}\-\d{2}\-\d{2}#si', $value);
    }

}