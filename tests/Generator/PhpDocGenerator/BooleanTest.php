<?php

namespace Tests\Er1z\FakeMock\Generator\PhpDocGenerator;

use Er1z\FakeMock\Metadata\FieldMetadata;
use Er1z\FakeMock\Generator\PhpDocGenerator\Boolean;

class BooleanTest extends AbstractTest
{
    public function testBoolean()
    {
        $g = new Boolean();
        $value = $g->generateForProperty(
            $this->createMock(FieldMetadata::class), $this->getGenerator()
        );

        $this->assertInternalType('bool', $value);
    }
}
