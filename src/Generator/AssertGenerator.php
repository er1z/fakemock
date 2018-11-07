<?php


namespace Er1z\FakeMock\Generator;


use Er1z\FakeMock\FieldMetadata;
use Faker\Factory;
use Faker\Generator;

/**
 * @todo: add interface with FakerableInterface in order to inject main Faker instance or sth
 * Class AssertGenerator
 * @package Er1z\FakeMock\Generator
 */
class AssertGenerator extends GeneratorAbstract
{
    /**
     * @var Generator
     */
    protected $generator;

    public function __construct(?Generator $generator = null)
    {
        $this->generator = $generator ?: Factory::create();
    }

    public function generateForProperty(FieldMetadata $field)
    {
        if(!$field->configuration->useAsserts){
            return null;
        }

        return parent::generateForProperty($field);
    }


    protected function getGeneratorFqcn($simpleClassName)
    {
        return sprintf('Er1z\\FakeMock\\Generator\\AssertGenerator\\%s', $simpleClassName);
    }
}