<?php

namespace Er1z\FakeMock\Generator;

use Er1z\FakeMock\FakeMock;
use Er1z\FakeMock\Generator\RecursiveGenerator\ClassMapper;
use Er1z\FakeMock\Generator\RecursiveGenerator\ClassMapperInterface;
use Er1z\FakeMock\Metadata\FieldMetadata;

class RecursiveGenerator implements GeneratorInterface
{
    /**
     * @var ClassMapperInterface
     */
    protected $classMapper;

    public function __construct(?ClassMapperInterface $classMapper = null)
    {
        $this->classMapper = $classMapper ?? new ClassMapper();
    }

    public function generateForProperty(FieldMetadata $field, FakeMock $fakemock, ?string $group = null)
    {
        if (!$field->configuration->recursive) {
            return null;
        }

        $value = $this->classMapper->getObjectForField($field);
        if (!$value) {
            return null;
        }

        $value = $fakemock->fill($value);

        return $value;
    }

    public function addClassMapping(string $intefaceOrAbstractFqcn, string $targetFqcn)
    {
        $this->classMapper->addClassMapping($intefaceOrAbstractFqcn, $targetFqcn);
    }
}
