<?php


namespace Er1z\FakeMock\Decorator\AssertDecorator;


use Er1z\FakeMock\FieldMetadata;
use Er1z\FakeMock\ObjectUtils;
use Symfony\Component\Validator\Constraint;

class NotEqualTo implements AssertDecoratorInterface
{

    public function decorate(&$value, FieldMetadata $field, Constraint $configuration, ?string $group = null): bool
    {
        /**
         * @var $configuration \Symfony\Component\Validator\Constraints\NotEqualTo
         */

        if(!is_scalar($value)){
            throw new \InvalidArgumentException('Only scalar values are supported');
        }

        if($configuration->value && $value==$configuration->value){
            $value .= mt_rand(0,9);
        }else if($configuration->propertyPath){
            $otherValue = ObjectUtils::getPropertyValue($field->object, $configuration->propertyPath);
            if($otherValue==$value){
                $value .= mt_rand(0,9);
            }
        }

        return true;
    }

}