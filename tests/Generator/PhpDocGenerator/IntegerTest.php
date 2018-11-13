<?php

namespace Tests\Er1z\FakeMock\Generator\PhpDocGenerator;

use Er1z\FakeMock\Metadata\FieldMetadata;
use Er1z\FakeMock\Generator\PhpDocGenerator\Integer;

class IntegerTest extends AbstractTest
{
    public function testFloat()
    {
        $g = new Integer();
        $value = $g->generateForProperty(
            $this->createMock(FieldMetadata::class), $this->getGenerator()
        );

        $this->assertInternalType('int', $value);
    }
}
