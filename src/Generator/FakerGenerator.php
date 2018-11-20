<?php

namespace Er1z\FakeMock\Generator;

use Er1z\FakeMock\FakeMock;
use Er1z\FakeMock\Faker\Registry;
use Er1z\FakeMock\Metadata\FieldMetadata;
use Faker\Factory;
use Faker\Guesser\Name;

class FakerGenerator implements GeneratorInterface
{
    /**
     * @var Name
     */
    private $guesser;
    /**
     * @var Registry
     */
    private $generator;

    public function __construct(?Name $guesser = null, ?Registry $generator = null)
    {
        if (!$guesser) {
            if (!$generator) {
                $generator = Factory::create();
            }

            $guesser = new Name($generator);
        }

        $this->guesser = $guesser;
        $this->generator = $generator;
    }

    public function generateForProperty(FieldMetadata $field, FakeMock $fakemock, ?string $group = null)
    {
        if ($field->configuration->faker) {
            return $this->generator->{$field->configuration->faker}(...(array) $field->configuration->arguments);
        }
        $format = $this->guesser->guessFormat($field->property->getName());

        if ($format) {
            return $format();
        }

        return null;
    }
}
