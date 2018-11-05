<?php


namespace Er1z\FakeMock\Decorator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;

interface DecoratorInterface
{
    public function decorate(&$value, $object, FakeMockField $configuration, AnnotationCollection $annotations): bool;
}