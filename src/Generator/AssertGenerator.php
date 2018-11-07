<?php


namespace Er1z\FakeMock\Generator;


use Er1z\FakeMock\FieldMetadata;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Validator\Constraint;

/**
 * @todo: add interface with FakerableInterface in order to inject main Faker instance or sth
 * Class AssertGenerator
 * @package Er1z\FakeMock\Generator
 */
class AssertGenerator implements GeneratorInterface
{
    /**
     * @var Generator
     */
    protected $generator;

    /**
     * @var \Er1z\FakeMock\Generator\AssertGenerator\GeneratorInterface[]
     */
    protected $generators = [];

    public function __construct(?Generator $generator = null)
    {
        $this->generator = $generator ?: Factory::create();
    }

    public function generateForProperty(
        FieldMetadata $field
    )
    {

        if(!$field->configuration->useAsserts){
            return null;
        }

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

    protected function getGenerator($assertClass){

        if(empty($this->generators[$assertClass])){
            $generatorFqcn = sprintf('Er1z\\FakeMock\\Generator\\AssertGenerator\\%s', $assertClass);
            $this->generators[$assertClass] = class_exists($generatorFqcn) ? new $generatorFqcn : false;
        }

        return $this->generators[$assertClass];
    }

}