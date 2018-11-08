<?php


namespace Tests\Er1z\FakeMock\Mocks;


use Er1z\FakeMock\Decorator\AssertDecorator\AssertDecoratorInterface;
use Er1z\FakeMock\Metadata\FieldMetadata;
use Symfony\Component\Validator\Constraint;

class AssertDecoratorMockNegative implements AssertDecoratorInterface
{
    const MOCK_VALUE = null;

    public function decorate(&$value, FieldMetadata $field, Constraint $configuration, ?string $group = null): bool
    {
        $value = self::MOCK_VALUE;

        return false;
    }

}