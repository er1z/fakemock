<?php

namespace Tests\Er1z\FakeMock\Generator\AssertGenerator;

use Er1z\FakeMock\Generator\AssertGenerator\Email;

class EmailTest extends GeneratorAbstractTest
{
    public function testEmail()
    {
        $generator = new Email();

        $field = $this->getFieldMetadata();

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\Email(),
            $this->getFaker()
        );

        $this->assertNotNull(
            filter_var($value, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE)
        );
    }
}
