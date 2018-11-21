<?php

namespace Er1z\FakeMock\Generator;

use Er1z\FakeMock\FakeMock;
use Er1z\FakeMock\Metadata\FieldMetadata;
use Symfony\Component\Validator\Constraint;

/**
 * @todo: add interface with FakerableInterface in order to inject main Faker instance or sth
 * Class AssertGenerator
 */
class AssertGenerator extends AttachableGeneratorAbstract
{
    public function generateForProperty(FieldMetadata $field, FakeMock $fakemock, ?string $group = null)
    {
        if (!$field->configuration->useAsserts) {
            return null;
        }

        $allAsserts = $field->annotations->findAllBy(Constraint::class);
        $asserts = $this->filterByGroup($allAsserts, $group);

        if ($asserts) {
            $assert = $asserts[0];

            // https://coderwall.com/p/cpxxxw/php-get-class-name-without-namespace - reflection is the fastest?
            $baseClass = new \ReflectionClass($assert);

            if ($generator = $this->getGenerator($baseClass->getShortName())) {
                return $generator->generateForProperty($field, $assert, $this->fakerRegistry->getGeneratorForField($field));
            }
        }

        return null;
    }

    protected function filterByGroup($asserts, ?string $group = null){
        if(is_null($group)){
            return $asserts;
        }

        $result = array_filter($asserts, function($a) use ($group){
            /**
             * @var $a Constraint
             */
            return in_array($group, $a->groups);
        });

        return array_values($result);
    }

    protected function getGeneratorFqcn($simpleClassName)
    {
        return sprintf('Er1z\\FakeMock\\Generator\\AssertGenerator\\%s', $simpleClassName);
    }
}
