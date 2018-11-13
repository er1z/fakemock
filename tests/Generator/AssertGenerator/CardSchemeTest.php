<?php

namespace Tests\Er1z\FakeMock\Generator\AssertGenerator;

use Er1z\FakeMock\Generator\AssertGenerator\CardScheme;

class CardSchemeTest extends GeneratorAbstractTest
{
    public function testCardSchemePass()
    {
        $generator = new CardScheme();

        $field = $this->getFieldMetadata();

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\CardScheme([
                'schemes' => ['visa'],
            ]),
            $this->getFaker()
        );

        $this->assertRegExp('/^4[0-9]{12}(?:[0-9]{3})?$\z/i', $value);
    }

    public function testCardSchemeFail()
    {
        $generator = new CardScheme();

        $field = $this->getFieldMetadata();

        $this->expectException(\InvalidArgumentException::class);
        $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\CardScheme([
                'schemes' => ['blablabla'],
            ]),
            $this->getFaker()
        );
    }
}
