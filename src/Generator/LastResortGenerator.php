<?php

namespace Er1z\FakeMock\Generator;

use Er1z\FakeMock\FakeMock;
use Er1z\FakeMock\Metadata\FieldMetadata;
use Faker\Factory;
use Faker\Generator;

class LastResortGenerator implements GeneratorInterface
{
    /**
     * @var Generator
     */
    private $generator;

    public function __construct(?Generator $generator = null)
    {
        $this->generator = $generator ?: Factory::create();
    }

    public function generateForProperty(FieldMetadata $field, FakeMock $fakemock)
    {
        return $this->generator->name();
    }
}
