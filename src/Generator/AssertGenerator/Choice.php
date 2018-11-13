<?php

namespace Er1z\FakeMock\Generator\AssertGenerator;

use Er1z\FakeMock\Metadata\FieldMetadata;
use Faker\Generator;
use Symfony\Component\Validator\Constraint;

class Choice implements GeneratorInterface
{
    public function generateForProperty(FieldMetadata $field, Constraint $constraint, Generator $faker)
    {
        /**
         * @var \Symfony\Component\Validator\Constraints\Choice
         */
        $options = $constraint->choices;

        if ($constraint->multiple) {
            $set = (array) array_rand($options, mt_rand(1, count($options)));
            $set = array_map(function ($el) use ($options) {
                return $options[$el];
            }, $set);

            return array_values($set);
        }

        return $options[array_rand($options)];
    }
}
