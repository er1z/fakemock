<?php


namespace Er1z\FakeMock\Decorator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Symfony\Component\Validator\Constraint;

class DecoratorChain implements DecoratorChainInterface
{

    /**
     * @var DecoratorInterface[]
     */
    protected $decorators;

    /**
     * DecoratorChain constructor.
     * @param DecoratorInterface[] $decorators
     */
    public function __construct($decorators = [])
    {
        if (!$decorators) {
            $decorators = self::getDefaultDecoratorsSet();
        }

        foreach ($decorators as $d) {
            $this->addDecorator($d);
        }

    }

    public static function getDefaultDecoratorsSet()
    {
        $result = [];

        if (class_exists(Constraint::class)) {
            $result[] = new AssertDecorator();
        }

        return $result;
    }

    public function getDecoratedValue($value, $object, FakeMockField $configuration, AnnotationCollection $annotations)
    {
        foreach ($this->decorators as $d) {
            if (!$d->decorate($value, $object, $configuration, $annotations)) {
                break;
            }
        }

        return $value;
    }

    public function addDecorator(DecoratorInterface $d)
    {
        $this->decorators[] = $d;
    }


}