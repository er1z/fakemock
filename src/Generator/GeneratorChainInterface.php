<?php

namespace Er1z\FakeMock\Generator;

use Er1z\FakeMock\Metadata\FieldMetadata;

interface GeneratorChainInterface
{
    public function getValueForField(
        FieldMetadata $field
    );
}
