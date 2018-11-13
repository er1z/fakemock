<?php

namespace Er1z\FakeMock\Metadata;

use Er1z\FakeMock\Annotations\FakeMock;

interface FactoryInterface
{
    public function create($object, FakeMock $objectConfiguration, \ReflectionProperty $property): ?FieldMetadata;

    public function getObjectConfiguration(\ReflectionClass $object): ?FakeMock;
}
