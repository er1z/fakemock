<?php


namespace Er1z\FakeMock\Decorator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\FieldMetadata;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\IdenticalTo;
use Symfony\Component\Validator\Constraints\NotEqualTo;
use Symfony\Component\Validator\Constraints\NotIdenticalTo;

class AssertDecorator implements DecoratorInterface
{

    public function decorate(
        &$value, FieldMetadata $field, ?string $group = null
    ): bool
    {
        $asserts = array_filter($field->annotations->findAllBy(Constraint::class), function($a) use ($group){
            /**
             * @var $a Constraint
             */
            return is_null($group) || in_array($group, $a->groups);
        });

        foreach($asserts as $a){
            switch(get_class($a)){
                case EqualTo::class:
                case IdenticalTo::class:
                    /**
                     * @var $a EqualTo|IdenticalTo
                     */
                    if(!empty($a->propertyPath)) {
                        return $this->getValueByPath($field->object, $a->propertyPath);
                    }else if(!empty($a->value)){
                        return $a->value;
                    }
                    break;

                case NotEqualTo::class:
                case NotIdenticalTo::class:
                    /**
                     * @var $a EqualTo|IdenticalTo
                     * @todo: distinguish from eq/ident
                     */
                    if(
                        !empty($a->propertyPath) && $this->getValueByPath($field->object, $a->propertyPath) == $value
                        || (!empty($a->value) && $a->value == $value)
                    )
                    {
                        $value .= '_';
                    }
                break;
            }
        }

        return false;
    }

    protected function checkLength($value, FakeMockField $config, AnnotationCollection $annotations)
    {

        if (!class_exists(Constraint::class)) {
            return $value;
        }

        if ($lengthConfig = $annotations->findOneBy(Length::class) && $config->satisfyAssertsConditions) {
            /**
             * @var $lengthConfig Length
             */
            $min = $lengthConfig->min;
            $max = $lengthConfig->max;
            if (!isset($value[$min])) {
                // todo: to const
                $value = str_pad($value, strlen($value) - $min, '_');
            } else if (isset($value[$max + 1])) {
                $value = substr($value, 0, $max);
            }
        }

        return $value;

    }

    protected function getValueByPath($obj, $path){
        $propertyAccessor = PropertyAccess::createPropertyAccessorBuilder()
            ->enableExceptionOnInvalidIndex()
            ->getPropertyAccessor();

        return $propertyAccessor->getValue($obj, $path);
    }

}