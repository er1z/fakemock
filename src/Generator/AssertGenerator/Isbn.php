<?php

namespace Er1z\FakeMock\Generator\AssertGenerator;

use Er1z\FakeMock\Metadata\FieldMetadata;
use Faker\Generator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Length;

class Isbn implements GeneratorInterface
{
    const DEFAULT_LENGTH = 13;

    public function generateForProperty(FieldMetadata $field, Constraint $constraint, Generator $faker)
    {
        /*
         * @var \Symfony\Component\Validator\Constraints\Isbn $constraint
         */

        /*
         * @var Length
         */
        if ($length = $field->annotations->findOneBy(Length::class)) {
            $max = $length->max ?: self::DEFAULT_LENGTH;
            if ($max >= 13) {
                return $faker->isbn13;
            }
        }

        return $faker->isbn10;
    }
}
