<?php

namespace Er1z\FakeMock\Generator\AssertGenerator;

use Er1z\FakeMock\Metadata\FieldMetadata;
use Er1z\FakeMock\Generator\TypedGenerator;
use Faker\Generator;
use Symfony\Component\Validator\Constraint;

class Regex implements GeneratorInterface
{
    public function generateForProperty(FieldMetadata $field, Constraint $constraint, Generator $faker)
    {
        /**
         * @var \Symfony\Component\Validator\Constraints\Regex $constraint
         */
        $generator = new TypedGenerator();

        return $generator->generateForRegex($constraint->pattern);
    }
}
