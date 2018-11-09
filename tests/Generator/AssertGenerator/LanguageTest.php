<?php

namespace Tests\Er1z\FakeMock\Generator\AssertGenerator;

use Er1z\FakeMock\Generator\AssertGenerator\Language;

class LanguageTest extends GeneratorAbstractTest
{
    public function testLanguage()
    {
        $generator = new Language();

        $field = $this->getFieldMetadata();

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\Language(),
            $this->getFaker()
        );

        $this->assertEquals(2, strlen($value));
    }
}
