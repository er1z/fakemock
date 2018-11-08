<?php


namespace Er1z\FakeMock\Generator\AssertGenerator;


use Er1z\FakeMock\Metadata\FieldMetadata;
use Faker\Generator;
use Symfony\Component\Intl\Intl;
use Symfony\Component\Validator\Constraint;

class Country implements GeneratorInterface
{

    public function generateForProperty(FieldMetadata $field, Constraint $constraint, Generator $faker)
    {
        if(class_exists('Symfony\Component\Intl\Intl')){
            return array_rand(Intl::getRegionBundle()->getCountryNames());
        }

        return $faker->countryCode;
    }
}