<?php


namespace Er1z\FakeMock\Detector\Detectors;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use phpDocumentor\Reflection\Type;
use Symfony\Component\Validator\Constraints\Range;

class Float_ implements DetectorInterface
{

    public function getConfigurationForType(\ReflectionProperty $property, FakeMockField $configuration, AnnotationCollection $annotations, Type $type): FakeMockField
    {

        $configuration->method = 'randomFloat';

        /**
         * @var $hasAssert Range
         */
        if(
            $configuration->useAsserts
            && class_exists('Symfony\Component\Validator\Constraints')
            && $hasAssert = $annotations->findOneBy(Range::class)
        ){
            $configuration->options = [
                null, $hasAssert->min, $hasAssert->max
            ];
        }

        return $configuration;

    }
}