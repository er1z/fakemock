<?php


namespace Er1z\FakeMock\Generator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Faker\Generator;
use Faker\Guesser\Name;

class FakerGenerator implements GeneratorInterface
{

    /**
     * @var Name
     */
    private $guesser;
    /**
     * @var Generator
     */
    private $generator;

    public function __construct(?Name $guesser = null, ?Generator $generator = null)
    {
        if (!$guesser) {
            if (!$generator) {
                $generator = new Generator();
            }

            $guesser = new Name($generator);
        }

        $this->guesser = $guesser;
        $this->generator = $generator;
    }

    public function generateForProperty($object, \ReflectionProperty $property, FakeMockField $configuration, AnnotationCollection $annotations)
    {
        if($configuration->faker){
            return $this->generator->{$configuration->faker}(...$configuration->arguments);
        }
        $format = $this->guesser->guessFormat($property->getName());

        return $format();
    }
}