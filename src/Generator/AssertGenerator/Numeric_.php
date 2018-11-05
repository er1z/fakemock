<?php


namespace Er1z\FakeMock\Generator\AssertGenerator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Symfony\Component\Validator\Constraints\Range;

abstract class Numeric_
{

    public function getConfigurationForNumericType($method, FakeMockField $configuration, AnnotationCollection $annotations, ?Type $type = null): FakeMockField
    {

        $configuration->method = $method;

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