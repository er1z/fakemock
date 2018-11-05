<?php


namespace Er1z\FakeMock\Generator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use ReverseRegex\Generator\Scope;
use ReverseRegex\Lexer;
use ReverseRegex\Parser;
use ReverseRegex\Random\SimpleRandom;
use Symfony\Component\Validator\Constraints\Regex;

class TypedGenerator implements GeneratorInterface
{

    public function generateForProperty(
        $object, \ReflectionProperty $property, FakeMockField $configuration, AnnotationCollection $annotations
    )
    {

        if($configuration->value){
            return $configuration->value;
        }

        /**
         * @var $regexConfig Regex
         */
        if(!$regexConfig = $annotations->findOneBy(Regex::class)){
            return $this->generateForRegex($configuration);
        }

    }

    protected function generateForRegex(FakeMockField $configuration){
        $lexer = new Lexer($configuration->pattern);
        $gen = new SimpleRandom();
        $result = '';

        $parser = new Parser($lexer, new Scope(), new Scope());
        $parser->parse()->getResult()->generate($result, $gen);

        return $result;
    }
}