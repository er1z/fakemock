<?php


namespace Tests\Er1z\FakeMock\Generator\AssertGenerator;


use Er1z\FakeMock\Generator\AssertGenerator\Time;

class TimeTest extends GeneratorAbstractTest
{

    public function testDate()
    {
        $generator = new Time();

        $field = $this->getFieldMetadata();

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\Time(),
            $this->getFaker()
        );

        $this->assertInternalType('string', $value);
        $this->assertRegExp('#\d{2}\:\d{2}\:\d{2}#si', $value);
    }

}