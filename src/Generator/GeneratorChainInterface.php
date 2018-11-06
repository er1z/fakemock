<?php


namespace Er1z\FakeMock\Generator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\FieldMetadata;

interface GeneratorChainInterface
{

    public function getValueForField(
        FieldMetadata $field
    );
}