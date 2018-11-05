<?php


namespace Er1z\FakeMock\Generator\AssertGenerator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use phpDocumentor\Reflection\Type;

class Float_ extends Numeric_ implements GeneratorInterface
{

    public function generateForType(\ReflectionProperty $property, FakeMockField $configuration, AnnotationCollection $annotations, ?Type $type = null): FakeMockField
    {
        return parent::getConfigurationForNumericType('randomFloat', $configuration, $annotations);
    }
}