<?php

namespace Tests\Er1z\FakeMock\Generator\PhpDocGenerator;

use Er1z\FakeMock\Metadata\FieldMetadata;
use Er1z\FakeMock\Generator\PhpDocGenerator\Float_;

class Float_Test extends AbstractTest
{
    public function testFloat()
    {
        $g = new Float_();
        $value = $g->generateForProperty(
            $this->createMock(FieldMetadata::class), $this->getGenerator()
        );

        $this->assertInternalType('float', $value);
    }
}
