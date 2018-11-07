<?php


namespace Er1z\FakeMock\Decorator;


use Er1z\FakeMock\FieldMetadata;

class AssertDecorator extends DecoratorAbstract
{

    public function decorate(
        &$value, FieldMetadata $field, ?string $group = null
    ): bool
    {

        if(!$field->configuration->satisfyAssertsConditions){
            return false;
        }

        return parent::decorate($value, $field, $group);
    }

    protected function getDecoratorFqcn($simpleClassName)
    {
        return sprintf('Er1z\\FakeMock\\Decorator\\AssertDecorator\\%s', $simpleClassName);
    }
}