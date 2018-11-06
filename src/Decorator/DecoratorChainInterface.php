<?php


namespace Er1z\FakeMock\Decorator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\FieldMetadata;

interface DecoratorChainInterface
{

    public function getDecoratedValue($value, FieldMetadata $field);
}