<?php


namespace Er1z\FakeMock\Generator\PhpDocGenerator;


use Er1z\FakeMock\FieldMetadata;
use Faker\Generator;

class Integer implements GeneratorInterface
{

    public function generateForProperty(FieldMetadata $field, Generator $faker)
    {
        return $faker->randomNumber();
    }
}