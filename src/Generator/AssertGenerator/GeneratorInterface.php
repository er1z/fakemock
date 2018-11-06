<?php


namespace Er1z\FakeMock\Generator\AssertGenerator;


use Er1z\FakeMock\Annotations\FakeMockField;

interface GeneratorInterface
{
    
    public function generateForType(FakeMockField $field);
}