<?php

namespace Tests\Er1z\FakeMock\Generator\AssertGenerator;

use Er1z\FakeMock\Generator\AssertGenerator\Currency;

class CurrencyTest extends GeneratorAbstractTest
{
    public function testCurrency()
    {
        $generator = new Currency();

        $field = $this->getFieldMetadata();

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\Currency(),
            $this->getFaker()
        );

        $this->assertInternalType('string', $value);
        $this->assertEquals(3, strlen($value));
    }
}
