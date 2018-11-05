<?php


namespace Er1z\FakeMock\Generator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Generator\AssertGenerator\Default_;
use phpDocumentor\Reflection\Type;

class AssertGenerator implements GeneratorInterface
{

    protected function getPhpDocType(\ReflectionProperty $property): ?Type
    {
        $factory = \phpDocumentor\Reflection\DocBlockFactory::createInstance();
        $data = $factory->create(
            $property->getDocComment()
        );

        if ($vars = $data->getTagsByName('var')) {
            return reset($vars)->getType();
        }

        return null;
    }

    public function generateForProperty(
        $object, \ReflectionProperty $property, FakeMockField $configuration, AnnotationCollection $annotations
    )
    {

        if(!$configuration->useAsserts){
            return null;
        }

        $type = $this->getPhpDocType($property);

        if ($type) {
            // https://coderwall.com/p/cpxxxw/php-get-class-name-without-namespace - reflection is the fastest?
            $baseClass = new \ReflectionClass($type);
            $class = sprintf('Er1z\\FakeMock\\Guesser\\AssertGuesser\\%s', $baseClass->getShortName());

            if (class_exists($class)) {
                /**
                 * @var $obj GeneratorInterface
                 */
                $obj = new $class;
            }
        }else{
            $obj = new Default_();
        }

        if(isset($obj)){
            return $obj->generateForType($property, $configuration, $annotations, $type);
        }
    }

}