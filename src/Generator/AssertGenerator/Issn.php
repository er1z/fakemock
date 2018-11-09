<?php

namespace Er1z\FakeMock\Generator\AssertGenerator;

use Er1z\FakeMock\Metadata\FieldMetadata;
use Faker\Generator;
use Symfony\Component\Validator\Constraint;

/**
 * @todo find a better way to generate issn
 * Class Luhn
 */
class Issn implements GeneratorInterface
{
    const HARDCODED_ISSN = '0170-6632';

    public function generateForProperty(FieldMetadata $field, Constraint $constraint, Generator $faker)
    {
        /*
         * @var \Symfony\Component\Validator\Constraints\Issn $constraint
         */

        return self::HARDCODED_ISSN;
    }
}
