<?php


namespace Er1z\FakeMock\Generator\AssertGenerator;


use Er1z\FakeMock\FieldMetadata;
use Faker\Generator;
use Symfony\Component\Validator\Constraint;

class Time implements GeneratorInterface
{

    public function generateForProperty(FieldMetadata $field, Constraint $constraint, Generator $faker)
    {
        /**
         * @var \Symfony\Component\Validator\Constraints\Time $constraint
         */
        return $faker->time();
    }
}