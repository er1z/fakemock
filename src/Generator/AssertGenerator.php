<?php


namespace Er1z\FakeMock\Generator;


use Er1z\FakeMock\FieldMetadata;
use phpDocumentor\Reflection\Type;

class AssertGenerator implements GeneratorInterface
{



    public function generateForProperty(
        FieldMetadata $field
    )
    {

        if(!$field->configuration->useAsserts){
            return null;
        }

        if ($field->type) {
            // https://coderwall.com/p/cpxxxw/php-get-class-name-without-namespace - reflection is the fastest?
            $baseClass = new \ReflectionClass($field->type);
            $class = sprintf('Er1z\\FakeMock\\Generator\\AssertGenerator\\%s', $baseClass->getShortName());

            if (class_exists($class)) {
                /**
                 * @var $obj GeneratorInterface
                 */
                $obj = new $class;
            }
        }

        if(isset($obj)){
            return $obj->generateForType($field);
        }
    }

}