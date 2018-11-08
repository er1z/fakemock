<?php


namespace Er1z\FakeMock\Generator;


use Er1z\FakeMock\FieldMetadata;
use Symfony\Component\Validator\Constraint;

/**
 * @todo: add interface with FakerableInterface in order to inject main Faker instance or sth
 * Class AssertGenerator
 * @package Er1z\FakeMock\Generator
 */
class AssertGenerator extends GeneratorAbstract
{
    public function generateForProperty(FieldMetadata $field)
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


    protected function getGeneratorFqcn($simpleClassName)
    {
        return sprintf('Er1z\\FakeMock\\Generator\\AssertGenerator\\%s', $simpleClassName);
    }
}