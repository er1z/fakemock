<?php


namespace Er1z\FakeMock\Faker;


use Faker\Generator;
use Faker\Guesser\Name;

interface RegistryInterface
{

    public function getGeneratorForLocale(?string $locale = null): Generator;
    public function getGuesserForLocale(?string $locale = null): Name;
}