<?php

namespace Tests\Er1z\FakeMock\Generator\AssertGenerator;

use Er1z\FakeMock\Generator\AssertGenerator\Iban;

class IbanTest extends GeneratorAbstractTest
{
    public function testIban()
    {
        $generator = new Iban();

        $field = $this->getFieldMetadata();

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\Iban(),
            $this->getFaker()
        );

        $this->assertTrue(ctype_alnum($value));
    }
}
