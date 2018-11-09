<?php

namespace Er1z\FakeMock\Generator\AssertGenerator;

use Er1z\FakeMock\Metadata\FieldMetadata;
use Faker\Generator;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\Validator\Constraint;

class DateTime implements GeneratorInterface
{
    const FORMAT = DATE_ATOM;

    public function generateForProperty(FieldMetadata $field, Constraint $constraint, Generator $faker)
    {
        /**
         * @var \Symfony\Component\Validator\Constraints\Date
         */
        $result = $faker->dateTime;
        if ($field->type instanceof String_) {
            $result = $result->format(self::FORMAT);
        }

        return $result;
    }
}
