<?php


namespace Er1z\FakeMock\Generator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\FieldMetadata;
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

    public function generateForProperty(FieldMetadata $field)
    {
        return $this->generator->name();
    }
}