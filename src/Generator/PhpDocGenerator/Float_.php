<?php


namespace Er1z\FakeMock\Generator\PhpDocGenerator;


use Er1z\FakeMock\FieldMetadata;
use Faker\Generator;

class Float_ implements GeneratorInterface
{

    public function generateForProperty(FieldMetadata $field, Generator $faker)
    {
        return $faker->randomFloat();
    }
}