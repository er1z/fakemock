<?php

namespace Tests\Er1z\FakeMock\Generator\AssertGenerator;

use Er1z\FakeMock\Generator\AssertGenerator\Url;

class UrlTest extends GeneratorAbstractTest
{
    public function testUrl()
    {
        $generator = new Url();

        $field = $this->getFieldMetadata();

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\Url(),
            $this->getFaker()
        );

        $this->assertNotNull(
            filter_var($value, FILTER_VALIDATE_URL, FILTER_NULL_ON_FAILURE)
        );
    }
}
