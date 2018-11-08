<?php


namespace Er1z\FakeMock\Generator\PhpDocGenerator;


use Er1z\FakeMock\FieldMetadata;
use Faker\Generator;

interface GeneratorInterface
{
    public function generateForProperty(FieldMetadata $field, Generator $faker);
}