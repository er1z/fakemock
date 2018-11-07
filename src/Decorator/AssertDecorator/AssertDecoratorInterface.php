<?php


namespace Er1z\FakeMock\Decorator\AssertDecorator;


use Er1z\FakeMock\FieldMetadata;
use Symfony\Component\Validator\Constraint;

interface AssertDecoratorInterface
{
    public function decorate(&$value, FieldMetadata $field, Constraint $configuration, ?string $group = null): bool;
}