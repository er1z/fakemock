<?php
namespace Er1z\FakeMock\Generator;


use Er1z\FakeMock\FieldMetadata;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Validator\Constraint;

abstract class GeneratorAbstract implements GeneratorInterface{

    /**
     * @var \Er1z\FakeMock\Generator\AssertGenerator\GeneratorInterface[]
     */
    protected $generators;

    /**
     * @var Generator
     */
    protected $generator;

    public function __construct(?Generator $generator = null)
    {
        $this->generator = $generator ?: Factory::create();
    }

    public function generateForProperty(
        FieldMetadata $field
    )
    {

        $asserts = $field->annotations->findAllBy(Constraint::class);

        if ($asserts) {

            $assert = $asserts[0];

            // https://coderwall.com/p/cpxxxw/php-get-class-name-without-namespace - reflection is the fastest?
            $baseClass = new \ReflectionClass($assert);

            if ($generator = $this->getGenerator($baseClass->getShortName())) {
                return $generator->generateForProperty($field, $assert, $this->generator);
            }
        }

        return null;
    }

    abstract protected function getGeneratorFqcn($simpleClassName);

    protected function getGenerator($assertClass){

        if(empty($this->generators[$assertClass])){
            $generatorFqcn = $this->getGeneratorFqcn($assertClass);
            $this->generators[$assertClass] = class_exists($generatorFqcn) ? new $generatorFqcn : false;
        }

        return $this->generators[$assertClass];
    }

}