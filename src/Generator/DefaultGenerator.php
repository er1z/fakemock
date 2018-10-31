<?php


namespace Er1z\FakeMock\Generator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Detector\DefaultFieldDetector;
use Er1z\FakeMock\Detector\FieldDetectorInterface;
use Faker\Factory;
use Faker\Generator;

class DefaultGenerator implements GeneratorInterface
{

    /**
     * @var string
     */
    private $locale;

    /**
     * @var Generator
     */
    private $faker;
    /**
     * @var FieldDetectorInterface
     */
    private $fieldDetector;

    public function __construct(string $locale = Factory::DEFAULT_LOCALE, ?FieldDetectorInterface $fieldDetector = null)
    {
        $this->locale = $locale;
        $this->faker = Factory::create($locale);
        $this->fieldDetector = $fieldDetector ?: new DefaultFieldDetector();
    }

    public function generateValue(\ReflectionProperty $property, FakeMockField $configuration, AnnotationCollection $annotations)
    {

        if(!$configuration->method){
            $obj = clone $configuration;
            $obj = $this->fieldDetector->getGeneratorArgumentsForUnmapped($property, $obj, $annotations);
        }else{
            $obj = $configuration;
        }

        return $this->faker->{$obj->method}(...(array)$obj->options);
    }
}