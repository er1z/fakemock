<?php

namespace Er1z\FakeMock\Generator;

use Er1z\FakeMock\FakeMock;
use Er1z\FakeMock\Faker\Registry;
use Er1z\FakeMock\Metadata\FieldMetadata;

abstract class AttachableGeneratorAbstract implements GeneratorInterface
{
    /**
     * @var \Er1z\FakeMock\Generator\AssertGenerator\GeneratorInterface[]
     */
    protected $generators;

    /**
     * @var Registry
     */
    protected $fakerRegistry;

    public function __construct(?Registry $registry = null)
    {
        $this->fakerRegistry = $registry ?: new Registry();
    }

    abstract public function generateForProperty(
        FieldMetadata $field, FakeMock $fakemock, ?string $group = null
    );

    abstract protected function getGeneratorFqcn($simpleClassName);

    protected function getGenerator($assertClass)
    {
        if (empty($this->generators[$assertClass])) {
            $generatorFqcn = $this->getGeneratorFqcn($assertClass);
            $this->generators[$assertClass] = class_exists($generatorFqcn) ? new $generatorFqcn() : false;
        }

        return $this->generators[$assertClass];
    }
}
