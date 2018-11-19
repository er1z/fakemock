<?php

namespace Er1z\FakeMock\Metadata;

use Er1z\FakeMock\Annotations\FakeMock;

interface FactoryInterface
{
    /**
     * @param $object
     * @param FakeMock $objectConfiguration
     * @param \ReflectionProperty $property
     * @return FieldMetadata[]
     */
    public function create($object, FakeMock $objectConfiguration, \ReflectionProperty $property);

    public function getObjectConfiguration(\ReflectionClass $object): ?FakeMock;
}
