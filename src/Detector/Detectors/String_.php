<?php


namespace Er1z\FakeMock\Detector\Detectors;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use phpDocumentor\Reflection\Type;

class String_ implements DetectorInterface
{

    public function getConfigurationForType(\ReflectionProperty $property, FakeMockField $configuration, AnnotationCollection $annotations, Type $type): FakeMockField
    {

        if(!$configuration->useAsserts){
            return $configuration;
        }

        $configuration = $this->getDateTimeTypes($configuration, $annotations);

        if($emailConfig = $annotations->findOneBy(\Symfony\Component\Validator\Constraints\Email::class)){
            $configuration->method = 'email';
        }

        if($emailConfig = $annotations->findOneBy(\Symfony\Component\Validator\Constraints\Url::class)){
            $configuration->method = 'url';
        }

        if($regexConfig = $annotations->findOneBy(\Symfony\Component\Validator\Constraints\Regex::class)){
            $configuration->method = null;
            $configuration->regex = $regexConfig->pattern;
        }

        return $configuration;
    }

    public function getDateTimeTypes(FakeMockField $configuration, AnnotationCollection $annotations): FakeMockField
    {
        // todo: class_exists
        if($datetimeConfig = $annotations->findOneBy(\Symfony\Component\Validator\Constraints\DateTime::class)){
            $configuration->method = 'iso8601';
        }

        if($dateConfig = $annotations->findOneBy(\Symfony\Component\Validator\Constraints\Date::class)){
            $configuration->method = 'date';
        }

        if($dateConfig = $annotations->findOneBy(\Symfony\Component\Validator\Constraints\Time::class)){
            $configuration->method = 'time';
        }

        return $configuration;
    }
}