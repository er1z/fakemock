<?php


namespace Er1z\FakeMock\Generator\AssertGenerator;


use Er1z\FakeMock\Metadata\FieldMetadata;
use Faker\Generator;
use Symfony\Component\Validator\Constraint;

interface GeneratorInterface
{
    
    public function generateForProperty(FieldMetadata $field, Constraint $constraint, Generator $faker);
}