<?php

namespace Er1z\FakeMock\Decorator\AssertDecorator;

use Er1z\FakeMock\Accessor;
use Er1z\FakeMock\Metadata\FieldMetadata;
use phpDocumentor\Reflection\Types\Float_;
use Symfony\Component\Validator\Constraint;

class LessThanOrEqual implements AssertDecoratorInterface
{
    public function decorate(&$value, FieldMetadata $field, Constraint $configuration, ?string $group = null): bool
    {
        if (!is_null($value) && !is_numeric($value)) {
            throw new \InvalidArgumentException('Non-numeric value supplied');
        }

        $trailer = 0;
        if ($this->useTrailer()) {
            $trailer = $field->type instanceof Float_ ? 0.00001 : 1;
        }

        /**
         * @var \Symfony\Component\Validator\Constraints\LessThan|\Symfony\Component\Validator\Constraints\LessThanOrEqual
         */
        if ($configuration->value && $value >= $configuration->value) {
            $value -= $value - $configuration->value + $trailer;
        } elseif ($configuration->propertyPath) {
            $compare = Accessor::getPropertyValue($field->object, $configuration->propertyPath);

            if (!is_numeric($compare)) {
                throw new \InvalidArgumentException('Non-numeric value supplied');
            }

            if ($value >= $compare) {
                $value -= $value - $compare + $trailer;
            }
        }

        return true;
    }

    protected function useTrailer()
    {
        return false;
    }
}
