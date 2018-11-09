<?php

namespace Tests\Er1z\FakeMock\Generator\AssertGenerator;

use Er1z\FakeMock\Generator\AssertGenerator\Regex;

class RegexTest extends GeneratorAbstractTest
{
    public function testRegex()
    {
        $generator = new Regex();

        $field = $this->getFieldMetadata();

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\Regex([
                'pattern' => '\d{5}',
            ]),
            $this->getFaker()
        );

        $this->assertEquals(
            1, preg_match('#(\d{5})#si', $value)
        );
    }
}
