<?php


namespace Er1z\FakeMock\Decorator\AssertDecorator;


use Er1z\FakeMock\FieldMetadata;
use phpDocumentor\Reflection\Types\Float_;
use Symfony\Component\Validator\Constraint;

class LessThan extends LessThanOrEqual
{

    public function decorate(&$value, FieldMetadata $field, Constraint $configuration, ?string $group = null): bool
    {
        /**
         * @var $configuration \Symfony\Component\Validator\Constraints\LessThan
         */

        // now it's less
        if(is_numeric($value)) {
            parent::decorate($value, $field, $configuration, $group);
            $value -= $field->type instanceof Float_ ? 0.00001 : 1;
        }

        return true;
    }
}