<?php

namespace Er1z\FakeMock\Decorator\AssertDecorator;

use Er1z\FakeMock\Metadata\FieldMetadata;
use Symfony\Component\Validator\Constraint;

class Length implements AssertDecoratorInterface
{
    const PAD_STRING = '_';

    public function decorate(&$value, FieldMetadata $field, Constraint $configuration, ?string $group = null): bool
    {
        /**
         * @var \Symfony\Component\Validator\Constraints\Length
         */
        $min = $configuration->min;
        $max = $configuration->max;
        if (!isset($value[$min])) {
            $value = str_pad($value, $min, self::PAD_STRING);
        } elseif (isset($value[$max + 1])) {
            $value = substr($value, 0, $max);
        }

        return true;
    }
}
