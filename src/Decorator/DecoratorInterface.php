<?php


namespace Er1z\FakeMock\Decorator;


use Er1z\FakeMock\Metadata\FieldMetadata;

interface DecoratorInterface
{
    public function decorate(&$value, FieldMetadata $field, ?string $group = null): bool;
}