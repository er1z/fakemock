<?php

namespace Er1z\FakeMock\Generator\AssertGenerator;

use Er1z\FakeMock\Metadata\FieldMetadata;
use Faker\Generator;
use Symfony\Component\Validator\Constraint;

/**
 * @todo more complex logic and create checksum composer require stocker4all/luhn-mod-n
 * Class Luhn
 */
class Luhn implements GeneratorInterface
{
    public function generateForProperty(FieldMetadata $field, Constraint $constraint, Generator $faker)
    {
        /*
         * @var \Symfony\Component\Validator\Constraints\Luhn $constraint
         */

        return $faker->creditCardNumber();
    }
}
