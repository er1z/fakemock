<?php

namespace Er1z\FakeMock\Generator;

use Er1z\FakeMock\FakeMock;
use Er1z\FakeMock\Faker\Registry;
use Er1z\FakeMock\Faker\RegistryInterface;
use Er1z\FakeMock\Metadata\FieldMetadata;

class FakerGenerator implements GeneratorInterface
{
    /**
     * @var Registry
     */
    private $fakerRegistry;

    public function __construct(?RegistryInterface $generator = null)
    {
        $this->fakerRegistry = $generator ?? new Registry();
    }

    public function generateForProperty(FieldMetadata $field, FakeMock $fakemock, ?string $group = null)
    {
        if ($field->configuration->faker) {
            return
                $this->fakerRegistry->getGeneratorForField($field)->{$field->configuration->faker}(
                    ...(array) $field->configuration->arguments
                );
        }
        $format =
            $this->fakerRegistry->getGuesserForLocale($field->configuration->locale)
            ->guessFormat($field->property->getName());

        if ($format) {
            return $format();
        }

        return null;
    }
}
