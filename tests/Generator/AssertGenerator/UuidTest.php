<?php


namespace Tests\Er1z\FakeMock\Generator\AssertGenerator;


use Er1z\FakeMock\Generator\AssertGenerator\Uuid;

class UuidTest extends GeneratorAbstractTest {

    public function testUrl()
    {
        $generator = new Uuid();

        $field = $this->getFieldMetadata();

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\Uuid(),
            $this->getFaker()
        );

        $this->assertEquals(
            1, preg_match('#([0-9A-Z\-]+)#si', $value)
        );
    }

}