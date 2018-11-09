<?php

namespace Er1z\FakeMock\Decorator\AssertDecorator;

use Er1z\FakeMock\Accessor;
use Er1z\FakeMock\Metadata\FieldMetadata;
use Symfony\Component\Validator\Constraint;

class EqualTo implements AssertDecoratorInterface
{
    public function decorate(&$value, FieldMetadata $field, Constraint $configuration, ?string $group = null): bool
    {
        /**
         * @var $configuration \Symfony\Component\Validator\Constraints\EqualTo
         */
        if ($configuration->value) {
            $value = $configuration->value;
        } elseif ($configuration->propertyPath) {
            $value = Accessor::getPropertyValue($field->object, $configuration->propertyPath);
        }

        return true;
    }
}
