<?php


namespace Er1z\FakeMock\Generator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Er1z\FakeMock\Detector\DefaultFieldDetector;
use Er1z\FakeMock\Detector\FieldDetectorInterface;
use Faker\Factory;
use Faker\Generator;
use ReverseRegex\Generator\Scope;
use ReverseRegex\Lexer;
use ReverseRegex\Parser;
use ReverseRegex\Random\SimpleRandom;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints\EqualTo;

class DefaultGenerator implements GeneratorInterface
{

    const DEFAULT_METHOD = 'name';

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

        if($obj->regex){
            return $this->generateForRegex($obj->regex);
        }

        if(!$obj->method){
            $obj->method = self::DEFAULT_METHOD;
        }

        return $this->faker->{$obj->method}(...(array)$obj->options);
    }

    protected function generateForRegex(string $regex){
        $lexer = new Lexer($regex);
        $gen   = new SimpleRandom();
        $result = '';

        $parser = new Parser($lexer,new Scope(),new Scope());
        $parser->parse()->getResult()->generate($result, $gen);

        return $result;
    }

}