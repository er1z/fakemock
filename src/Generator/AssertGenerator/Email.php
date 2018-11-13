<?php

namespace Er1z\FakeMock\Generator\AssertGenerator;

use Er1z\FakeMock\Metadata\FieldMetadata;
use Faker\Generator;
use Symfony\Component\Validator\Constraint;

class Email implements GeneratorInterface
{
    public function generateForProperty(FieldMetadata $field, Constraint $constraint, Generator $faker)
    {
        return $faker->email;
    }
}
