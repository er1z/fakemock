<?php

namespace Er1z\FakeMock\Decorator;

use Er1z\FakeMock\Metadata\FieldMetadata;

interface DecoratorChainInterface
{
    public function getDecoratedValue($value, FieldMetadata $field);
}
