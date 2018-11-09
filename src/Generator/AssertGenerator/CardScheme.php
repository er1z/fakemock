<?php

namespace Er1z\FakeMock\Generator\AssertGenerator;

use Er1z\FakeMock\Metadata\FieldMetadata;
use Faker\Generator;
use Symfony\Component\Validator\Constraint;

class CardScheme implements GeneratorInterface
{
    const SUPPORTED_PROVIDERS = [
        'visa' => 'Visa',
        'amex' => 'American Express',
        'mastercard' => 'Mastercard',
    ];

    public function generateForProperty(FieldMetadata $field, Constraint $constraint, Generator $faker)
    {
        /**
         * @var \Symfony\Component\Validator\Constraints\CardScheme
         */
        $providers = $constraint->schemes;
        if (!empty($providers)) {
            foreach ($providers as $p) {
                $p = strtolower($p);
                if (array_key_exists($p, self::SUPPORTED_PROVIDERS)) {
                    $provider = self::SUPPORTED_PROVIDERS[$p];
                    break;
                }
            }

            if (empty($provider)) {
                throw new \InvalidArgumentException(
                    sprintf('Cannot find supported among: %s', implode(', ', $providers))
                );
            }
        }

        return $faker->creditCardNumber($provider);
    }
}
