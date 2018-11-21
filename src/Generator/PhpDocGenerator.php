<?php

namespace Er1z\FakeMock\Generator;

use Er1z\FakeMock\FakeMock;
use Er1z\FakeMock\Metadata\FieldMetadata;

class PhpDocGenerator extends AttachableGeneratorAbstract
{
    protected function getGeneratorFqcn($simpleClassName)
    {
        return sprintf('Er1z\\FakeMock\\Generator\\PhpDocGenerator\\%s', $simpleClassName);
    }

    public function generateForProperty(FieldMetadata $field, FakeMock $fakemock, ?string $group = null)
    {
        if (!$field->type) {
            return null;
        }

        $baseClass = new \ReflectionClass($field->type);

        /**
         * @var $generator \Er1z\FakeMock\Generator\PhpDocGenerator\GeneratorInterface
         */
        if ($generator = $this->getGenerator($baseClass->getShortName())) {
            return $generator->generateForProperty($field, $this->fakerRegistry->getGeneratorForField($field));
        }

        return null;
    }
}
