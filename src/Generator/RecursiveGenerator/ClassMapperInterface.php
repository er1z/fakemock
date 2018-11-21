<?php

namespace Er1z\FakeMock\Generator\RecursiveGenerator;

use Er1z\FakeMock\Metadata\FieldMetadata;

interface ClassMapperInterface
{
    public function addClassMapping(string $abstractOrInterface, string $class);

    public function getObjectForField(FieldMetadata $field);
}
