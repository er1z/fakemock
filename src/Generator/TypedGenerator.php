<?php


namespace Er1z\FakeMock\Generator;


use Er1z\FakeMock\FieldMetadata;
use ReverseRegex\Generator\Scope;
use ReverseRegex\Lexer;
use ReverseRegex\Parser;
use ReverseRegex\Random\SimpleRandom;

class TypedGenerator implements GeneratorInterface
{

    public function generateForProperty(
        FieldMetadata $field
    )
    {

        if($field->configuration->value){
            return $field->configuration->value;
        }

        if($field->configuration->regex){
            return $this->generateForRegex($field->configuration->regex);
        }

    }

    protected function generateForRegex(string $regex){
        $lexer = new Lexer($regex);
        $gen = new SimpleRandom();
        $result = '';

        $parser = new Parser($lexer, new Scope(), new Scope());
        $parser->parse()->getResult()->generate($result, $gen);

        return $result;
    }
}