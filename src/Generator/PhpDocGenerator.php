<?php

namespace Er1z\FakeMock\Generator;

use Er1z\FakeMock\Metadata\FieldMetadata;

class PhpDocGenerator extends AttachableGeneratorAbstract
{
    protected function getGeneratorFqcn($simpleClassName)
    {
        return sprintf('Er1z\\FakeMock\\Generator\\PhpDocGenerator\\%s', $simpleClassName);
    }

    public function generateForProperty(FieldMetadata $field)
    {
        if (!$field->type) {
            return null;
        }

        $baseClass = new \ReflectionClass($field->type);

        /**
         * @var \Er1z\FakeMock\Generator\PhpDocGenerator\GeneratorInterface
         */
        if ($generator = $this->getGenerator($baseClass->getShortName())) {
            return $generator->generateForProperty($field, $this->generator);
        }

        return null;
    }
}
