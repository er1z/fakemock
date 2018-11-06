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
    protected $generator;

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
            $class = sprintf('Er1z\\FakeMock\\Generator\\AssertGenerator\\%s', $baseClass->getShortName());

            if (class_exists($class)) {
                /**
                 * @var \Er1z\FakeMock\Generator\AssertGenerator\GeneratorInterface $obj
                 */
                $obj = new $class;
                return $obj->generateForProperty($field, $assert, $this->generator);
            }
        }

        return null;
    }

}