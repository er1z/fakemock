<?php

namespace Tests\Er1z\FakeMock\Generator\AssertGenerator;

use Er1z\FakeMock\Generator\AssertGenerator\Range;
use phpDocumentor\Reflection\Types\Float_;
use phpDocumentor\Reflection\Types\Integer;

class RangeTest extends GeneratorAbstractTest
{
    public function testInt()
    {
        $generator = new Range();

        $field = $this->getFieldMetadata(new Integer());

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\Range([
                'min' => 1,
                'max' => 10,
            ]),
            $this->getFaker()
        );

        $this->assertInternalType('int', $value);
        $this->assertGreaterThanOrEqual(1, $value);
        $this->assertLessThanOrEqual(10, $value);
    }

    public function testFloat()
    {
        $generator = new Range();

        $field = $this->getFieldMetadata([], new Float_());

        $value = $generator->generateForProperty(
            $field,
            new \Symfony\Component\Validator\Constraints\Range([
                'min' => 1,
                'max' => 10,
            ]),
            $this->getFaker()
        );

        $this->assertInternalType('float', $value);
        $this->assertGreaterThanOrEqual(1, $value);
        $this->assertLessThanOrEqual(10, $value);
    }
}
