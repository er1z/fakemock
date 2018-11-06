<?php


namespace Er1z\FakeMock\Generator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Faker\Factory;
use Faker\Generator;

class LastResortGenerator implements GeneratorInterface
{

    /**
     * @var Generator
     */
    private $generator;

    public function __construct(?Generator $generator = null)
    {
        $this->generator = $generator ?: Factory::create();
    }

    public function generateForProperty($object, \ReflectionProperty $property, FakeMockField $configuration, AnnotationCollection $annotations)
    {
        return $this->generator->name();
    }
}