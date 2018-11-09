<?php

namespace Er1z\FakeMock\Generator\AssertGenerator;

use Er1z\FakeMock\Metadata\FieldMetadata;
use Faker\Generator;
use phpDocumentor\Reflection\Types\Float_;
use Symfony\Component\Validator\Constraint;

class Range implements GeneratorInterface
{
    public function generateForProperty(FieldMetadata $field, Constraint $constraint, Generator $faker)
    {
        /**
         * @var \Symfony\Component\Validator\Constraints\Range
         */
        $min = $constraint->min;
        $max = $constraint->max;

        if ($field->type instanceof Float_) {
            return $faker->randomFloat(null, $min, $max);
        }

        return mt_rand($min, $max);
    }
}
