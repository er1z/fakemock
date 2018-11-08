<?php


namespace Tests\Er1z\FakeMock\Generator\AssertGenerator;


use Er1z\FakeMock\Generator\AssertGenerator\Issn;

class IssnTest extends GeneratorAbstractTest
{

    public function testIssn()
    {
        $generator = new Issn();

        $field = $this->getFieldMetadata();

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\Issn(),
            $this->getFaker()
        );

        $this->assertEquals(\Er1z\FakeMock\Generator\AssertGenerator\Issn::HARDCODED_ISSN, $value);
    }

}