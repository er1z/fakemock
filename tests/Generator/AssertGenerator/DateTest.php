<?php


namespace Tests\Er1z\FakeMock\Generator\AssertGenerator;


use Er1z\FakeMock\Generator\AssertGenerator\Date;

class DateTest extends GeneratorAbstractTest
{

    public function testDate()
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

}