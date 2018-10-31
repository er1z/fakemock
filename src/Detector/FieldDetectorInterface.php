<?php


namespace Er1z\FakeMock\Detector;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;

interface FieldDetectorInterface
{
    public function getGeneratorArgumentsForUnmapped(\ReflectionProperty $property, FakeMockField $configuration, AnnotationCollection $annotations);
}