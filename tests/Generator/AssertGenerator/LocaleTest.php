<?php


namespace Tests\Er1z\FakeMock\Generator\AssertGenerator;

use Er1z\FakeMock\Generator\AssertGenerator\Locale;

class LocaleTest extends GeneratorAbstractTest
{

    public function testLanguage()
    {
        $generator = new Locale();

        $field = $this->getFieldMetadata();

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\Locale(),
            $this->getFaker()
        );

        $this->assertRegExp('#[a-z]_[A-Z].*#s', $value);
    }

}