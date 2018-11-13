<?php

namespace Er1z\FakeMock\Decorator;

use Er1z\FakeMock\Decorator\AssertDecorator\AssertDecoratorInterface;
use Er1z\FakeMock\Metadata\FieldMetadata;
use Symfony\Component\Validator\Constraint;

abstract class DecoratorAbstract implements DecoratorInterface
{
    /**
     * @var DecoratorInterface[]
     */
    protected $decorators = [];

    public function decorate(
        &$value, FieldMetadata $field, ?string $group = null
    ): bool {
        $asserts = $field->annotations->findAllBy(Constraint::class);

        foreach ($asserts as $a) {
            $refl = new \ReflectionClass($a);
            $basename = $refl->getShortName();

            $result = true;
            if ($decorator = $this->getDecorator($basename)) {
                $result = $decorator->decorate($value, $field, $a, $group);
            }

            if (!$result) {
                break;
            }
        }

        return true;
    }

    abstract protected function getDecoratorFqcn($simpleClassName);

    protected function getDecorator($assertClass): ?AssertDecoratorInterface
    {
        if (empty($this->decorators[$assertClass])) {
            $decoratorFqcn = $this->getDecoratorFqcn($assertClass);
            $this->decorators[$assertClass] = class_exists($decoratorFqcn) ? new $decoratorFqcn() : null;
        }

        return $this->decorators[$assertClass];
    }
}
