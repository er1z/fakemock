<?php


namespace Er1z\FakeMock\Decorator\AssertDecorator;


use Er1z\FakeMock\Accessor;
use Er1z\FakeMock\Metadata\FieldMetadata;
use Symfony\Component\Validator\Constraint;

class GreaterThanOrEqual implements AssertDecoratorInterface
{
    public function decorate(&$value, FieldMetadata $field, Constraint $configuration, ?string $group = null): bool
    {
        if(!is_null($value) && !is_numeric($value)){
            throw new \InvalidArgumentException('Non-numeric value supplied');
        }

        /**
         * @var $configuration \Symfony\Component\Validator\Constraints\GreaterThan
         */
        if($configuration->value && $value<$configuration->value){
            $value += $value-$configuration->value;
        }else if($configuration->propertyPath){
            $compare = Accessor::getPropertyValue($field->object, $configuration->propertyPath);

            if(!is_numeric($compare)){
                throw new \InvalidArgumentException('Non-numeric value supplied');
            }

            if($value<$compare){
                $value += $value-$compare;
            }
        }

        return true;
    }
}