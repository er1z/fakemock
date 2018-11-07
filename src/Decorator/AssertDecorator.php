<?php


namespace Er1z\FakeMock\Decorator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Decorator\AssertDecorator\AssertDecoratorInterface;
use Er1z\FakeMock\FieldMetadata;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\IdenticalTo;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotEqualTo;
use Symfony\Component\Validator\Constraints\NotIdenticalTo;

class AssertDecorator implements DecoratorInterface
{

    public function decorate(
        &$value, FieldMetadata $field, ?string $group = null
    ): bool
    {

        if(!$field->configuration->satisfyAssertsConditions){
            return false;
        }

        $asserts = $field->annotations->findAllBy(Constraint::class);

        foreach($asserts as $a){

            $refl = new \ReflectionClass($a);
            $basename = $refl->getShortName();

            $className = sprintf('Er1z\\FakeMock\\Decorator\\AssertDecorator\\%s', $basename);

            if(class_exists($className)){
                /**
                 * @var AssertDecoratorInterface $obj
                 */
                $obj = new $className();
                $obj->decorate($value, $field, $a, $group);
            }

        }

        return true;
    }

}