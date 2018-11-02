<?php


namespace Er1z\FakeMock\Condition;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\EqualTo;

class Processor implements ProcessorInterface
{

    public function processConditions(
        $object, FakeMockField $configuration, AnnotationCollection $annotations, $group = null
    ){
        $asserts = array_filter($annotations->findAllBy(Constraint::class), function($a) use ($group){
            /**
             * @var $a Constraint
             */
            return is_null($group) || in_array($group, $a->groups);
        });

        foreach($asserts as $a){
            switch(get_class($a)){
                case EqualTo::class:
                    /**
                     * @var $a EqualTo
                     */
                    if(!empty($a->propertyPath)) {
                        return $this->getValueByPath($object, $a->propertyPath);
                    }else if(!empty($a->value)){
                        return $a->value;
                    }
            }
        }
    }

    protected function getValueByPath($obj, $path){
        $propertyAccessor = PropertyAccess::createPropertyAccessorBuilder()
            ->enableExceptionOnInvalidIndex()
            ->getPropertyAccessor();

        return $propertyAccessor->getValue($obj, $path);
    }

}