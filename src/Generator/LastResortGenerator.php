<?php

namespace Er1z\FakeMock\Generator;

use Er1z\FakeMock\FakeMock;
use Er1z\FakeMock\Faker\Registry;
use Er1z\FakeMock\Faker\RegistryInterface;
use Er1z\FakeMock\Metadata\FieldMetadata;

class LastResortGenerator implements GeneratorInterface
{
    /**
     * @var Registry
     */
    private $fakerRegistry;

    public function __construct(?RegistryInterface $fakerRegistry = null)
    {
        $this->fakerRegistry = $fakerRegistry ?: new Registry();
    }

    public function generateForProperty(FieldMetadata $field, FakeMock $fakemock, ?string $group = null)
    {
        return $this->fakerRegistry->getGeneratorForField($field)->name();
    }
}
