<?php

namespace Er1z\FakeMock\Decorator\AssertDecorator;

use Er1z\FakeMock\Accessor;
use Er1z\FakeMock\Metadata\FieldMetadata;
use Symfony\Component\Validator\Constraint;

class NotEqualTo implements AssertDecoratorInterface
{
    public function decorate(&$value, FieldMetadata $field, Constraint $configuration, ?string $group = null): bool
    {
        /*
         * @var $configuration \Symfony\Component\Validator\Constraints\NotEqualTo
         */

        if (!is_scalar($value)) {
            throw new \InvalidArgumentException('Only scalar values are supported');
        }

        if ($configuration->value && $value == $configuration->value) {
            $value .= mt_rand(0, 9);
        } elseif ($configuration->propertyPath) {
            $otherValue = Accessor::getPropertyValue($field->object, $configuration->propertyPath);
            if ($otherValue == $value) {
                $value .= mt_rand(0, 9);
            }
        }

        return true;
    }
}
