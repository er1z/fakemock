<?php


namespace Er1z\FakeMock\Generator\AssertGenerator;


use Er1z\FakeMock\FieldMetadata;
use Faker\Generator;
use Symfony\Component\Validator\Constraint;

class Locale implements GeneratorInterface
{

    public function generateForProperty(FieldMetadata $field, Constraint $constraint, Generator $faker)
    {
        return $faker->locale;
    }
}