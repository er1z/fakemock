<?php


namespace Er1z\FakeMock\Generator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use ReverseRegex\Generator\Scope;
use ReverseRegex\Lexer;
use ReverseRegex\Parser;
use ReverseRegex\Random\SimpleRandom;

class TypedGenerator implements GeneratorInterface
{

    public function generateForProperty(
        $object, \ReflectionProperty $property, FakeMockField $configuration, AnnotationCollection $annotations
    )
    {

        if($configuration->value){
            return $configuration->value;
        }

        if($configuration->regex){
            return $this->generateForRegex($configuration);
        }

    }

    protected function generateForRegex(FakeMockField $configuration){
        $lexer = new Lexer($configuration->regex);
        $gen = new SimpleRandom();
        $result = '';

        $parser = new Parser($lexer, new Scope(), new Scope());
        $parser->parse()->getResult()->generate($result, $gen);

        return $result;
    }
}