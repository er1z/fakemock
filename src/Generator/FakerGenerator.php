<?php


namespace Er1z\FakeMock\Generator;


use Er1z\FakeMock\FieldMetadata;
use Faker\Factory;
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
                $generator = Factory::create();
            }

            $guesser = new Name($generator);
        }

        $this->guesser = $guesser;
        $this->generator = $generator;
    }

    public function generateForProperty(FieldMetadata $field)
    {
        if($field->configuration->faker){
            if(is_callable([$this->generator, $field->configuration->faker])) {
                return $this->generator->{$field->configuration->faker}(...(array)$field->configuration->arguments);
            }else{
                return $this->generator->{$field->configuration->faker};
            }
        }
        $format = $this->guesser->guessFormat($field->property->getName());

        if($format){
            return $format();
        }

        return null;
    }
}