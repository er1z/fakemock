<?php


namespace Er1z\FakeMock\Generator\AssertGenerator;


use Er1z\FakeMock\FieldMetadata;
use Faker\Generator;
use Symfony\Component\Validator\Constraint;

/**
 * @todo more complex logic and create checksum composer require stocker4all/luhn-mod-n
 * Class Luhn
 * @package Er1z\FakeMock\Generator\AssertGenerator
 */
class Luhn implements GeneratorInterface
{

    public function generateForProperty(FieldMetadata $field, Constraint $constraint, Generator $faker)
    {
        /**
         * @var \Symfony\Component\Validator\Constraints\Luhn $constraint
         */

        return $faker->creditCardNumber();
    }
}