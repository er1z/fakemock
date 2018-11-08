<?php
namespace Er1z\FakeMock\Generator;


use Er1z\FakeMock\Metadata\FieldMetadata;
use Faker\Factory;
use Faker\Generator;

abstract class AttachableGeneratorAbstract implements GeneratorInterface{

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

    abstract public function generateForProperty(
        FieldMetadata $field
    );

    abstract protected function getGeneratorFqcn($simpleClassName);

    protected function getGenerator($assertClass){

        if(empty($this->generators[$assertClass])){
            $generatorFqcn = $this->getGeneratorFqcn($assertClass);
            $this->generators[$assertClass] = class_exists($generatorFqcn) ? new $generatorFqcn : false;
        }

        return $this->generators[$assertClass];
    }

}