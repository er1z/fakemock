<?php

namespace Er1z\FakeMock\Generator;

use Er1z\FakeMock\FakeMock;
use Er1z\FakeMock\Metadata\FieldMetadata;

interface GeneratorInterface
{
    public function generateForProperty(
        FieldMetadata $field, FakeMock $fakemock
    );
}
