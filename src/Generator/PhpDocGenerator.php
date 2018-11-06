<?php


namespace Er1z\FakeMock\Generator;


use Er1z\FakeMock\FieldMetadata;

class PhpDocGenerator implements GeneratorInterface
{

    public function generateForProperty(FieldMetadata $field)
    {
        $baseClass = new \ReflectionClass($field->type);

        return null;
    }
}