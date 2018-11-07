<?php


namespace Er1z\FakeMock\Decorator\AssertDecorator;


use Er1z\FakeMock\FieldMetadata;
use Er1z\FakeMock\ObjectUtils;
use Symfony\Component\Validator\Constraint;

class EqualTo implements AssertDecoratorInterface
{

    public function decorate(&$value, FieldMetadata $field, Constraint $configuration, ?string $group = null): bool
    {
        /**
         * @var $configuration \Symfony\Component\Validator\Constraints\EqualTo
         */

        if($configuration->value){
            $value = $configuration->value;
        }else if($configuration->propertyPath){
            $value = ObjectUtils::getPropertyValue($field->object, $configuration->propertyPath);
        }

        return true;
    }
}