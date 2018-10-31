<?php


namespace Er1z\FakeMock\Detector\Detectors;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Detector\DetectorInterface;
use Symfony\Component\Validator\Constraints\Range;

class Float_ implements DetectorInterface
{

    public function getConfigurationForType(\ReflectionProperty $property, FakeMockField $configuration, AnnotationCollection $annotations): FakeMockField
    {

        $configuration->method = 'float';

        /**
         * @var $hasAssert Range
         */
        if(
            class_exists('Symfony\Component\Validator\Constraints')
            && $hasAssert = $annotations->getOneBy(Range::class)
        ){
            $configuration->options = [
                null, $hasAssert->min, $hasAssert->max
            ];
        }

        return $configuration;

    }
}