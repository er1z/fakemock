<?php


namespace Er1z\FakeMock\Generator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;

interface GeneratorChainInterface
{

    public function getValueForField(
        $object, \ReflectionProperty $property, FakeMockField $configuration, AnnotationCollection $annotations
    );
}