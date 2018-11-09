<?php

namespace Tests\Er1z\FakeMock\Generator\AssertGenerator;

use Er1z\FakeMock\Generator\AssertGenerator\Bic;

class BicTest extends GeneratorAbstractTest
{
    public function testBic()
    {
        $generator = new Bic();

        $field = $this->getFieldMetadata();

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\Bic(),
            $this->getFaker()
        );

        $this->assertRegExp('/^[a-z]{6}[0-9a-z]{2}([0-9a-z]{3})?\z/i', $value);
    }
}
