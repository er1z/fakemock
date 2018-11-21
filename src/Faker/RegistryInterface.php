<?php

namespace Er1z\FakeMock\Faker;

use Er1z\FakeMock\Metadata\FieldMetadata;
use Faker\Generator;
use Faker\Guesser\Name;

interface RegistryInterface
{
    public function getGeneratorForLocale(?string $locale = null): Generator;

    public function getGuesserForLocale(?string $locale = null): Name;

    public function getGeneratorForField(FieldMetadata $fieldMetadata);
}
