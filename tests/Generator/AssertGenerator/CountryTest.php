<?php


namespace Tests\Er1z\FakeMock\Generator\AssertGenerator;


use Er1z\FakeMock\Generator\AssertGenerator\Country;

class CountryTest extends GeneratorAbstractTest
{

    public function testCountry()
    {
        $generator = new Country();

        $field = $this->getFieldMetadata();

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\Country(),
            $this->getFaker()
        );

        $this->assertRegExp('#[A-Z]{2}#s', $value);
    }

}