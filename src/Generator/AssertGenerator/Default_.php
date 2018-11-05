<?php


namespace Er1z\FakeMock\Generator\AssertGenerator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use phpDocumentor\Reflection\Type;
use Symfony\Component\Validator\Constraints\Regex;

class Default_ implements GeneratorInterface
{

    public function generateForType(\ReflectionProperty $property, FakeMockField $configuration, AnnotationCollection $annotations, ?Type $type = null): FakeMockField
    {

        if(!$configuration->useAsserts){
            return $configuration;
        }
        
        /**
         * @var $regexConfig Regex
         */
        if($regexConfig = $annotations->findOneBy(Regex::class)){
            $configuration->method = null;
            $configuration->regex = $regexConfig->pattern;
        }

        return $configuration;
    }
}