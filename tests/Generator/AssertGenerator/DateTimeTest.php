<?php

namespace Tests\Er1z\FakeMock\Generator\AssertGenerator;

use Er1z\FakeMock\Generator\AssertGenerator\DateTime;
use phpDocumentor\Reflection\Types\String_;

class DateTimeTest extends GeneratorAbstractTest
{
    public function testDateTime()
    {
        $generator = new DateTime();

        $field = $this->getFieldMetadata();

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\DateTime(),
            $this->getFaker()
        );

        $this->assertInstanceOf(\DateTime::class, $value);
    }

    public function testDateTimeAsString()
    {
        $generator = new DateTime();

        $field = $this->getFieldMetadata([], new String_());

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\DateTime(),
            $this->getFaker()
        );

        $this->assertInternalType('string', $value);
        $this->assertRegExp('#^\d{4}\-\d{2}\-\d{2}.\d{2}\:\d{2}\:\d{2}.*#si', $value);
    }
}
