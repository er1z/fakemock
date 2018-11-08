<?php


namespace Er1z\FakeMock\Decorator\AssertDecorator;


use Er1z\FakeMock\Metadata\FieldMetadata;
use phpDocumentor\Reflection\Types\Float_;
use Symfony\Component\Validator\Constraint;

class GreaterThan extends LessThanOrEqual
{

    public function decorate(&$value, FieldMetadata $field, Constraint $configuration, ?string $group = null): bool
    {
        /**
         * @var $configuration \Symfony\Component\Validator\Constraints\GreaterThan
         */

        parent::decorate($value, $field, $configuration, $group);
        // now it's greater
        $value += $field->type instanceof Float_ ? 0.00001 : 1;

        return true;
    }
}