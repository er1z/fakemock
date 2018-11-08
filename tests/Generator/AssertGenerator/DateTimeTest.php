<?php


namespace Tests\Er1z\FakeMock\Generator\AssertGenerator;


use Er1z\FakeMock\Generator\AssertGenerator\DateTime;

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

}