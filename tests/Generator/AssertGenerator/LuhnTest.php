<?php


namespace Tests\Er1z\FakeMock\Generator\AssertGenerator;


use Er1z\FakeMock\Generator\AssertGenerator\Luhn;

class LuhnTest extends GeneratorAbstractTest
{

    public function testLuhn()
    {
        $generator = new Luhn();

        $field = $this->getFieldMetadata();

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\Luhn(),
            $this->getFaker()
        );

        $this->assertRegExp('#[0-9]+#si', $value);
    }

}