<?php


namespace Er1z\FakeMock;


use Er1z\FakeMock\Annotations\FakeMock as MainAnnotation;
use Er1z\FakeMock\Decorator\DecoratorChain;
use Er1z\FakeMock\Decorator\DecoratorChainInterface;
use Er1z\FakeMock\Metadata\Factory;
use Er1z\FakeMock\Metadata\FactoryInterface;
use Er1z\FakeMock\Generator\GeneratorChain;
use Er1z\FakeMock\Generator\GeneratorChainInterface;

class FakeMock
{

    /**
     * @var GeneratorChainInterface
     */
    private $generatorChain;
    /**
     * @var DecoratorChainInterface
     */
    private $decoratorChain;
    /**
     * @var FactoryInterface
     */
    private $metadataFactory;

    public function __construct(
        ?FactoryInterface $metadataFactory = null, ?GeneratorChainInterface $generatorChain = null, ?DecoratorChainInterface $decoratorChain = null
    )
    {
        $this->generatorChain = $generatorChain ?? new GeneratorChain();
        $this->decoratorChain = $decoratorChain ?? new DecoratorChain();
        $this->metadataFactory = $metadataFactory ?? new Factory();
    }

    public function fill($objectOrClassName, $group = null, $newObjectArguments = [])
    {
        $obj = $this->getClass($objectOrClassName, $newObjectArguments);

        $reflection = new \ReflectionClass($obj);
        $cfg = $this->metadataFactory->getObjectConfiguration($reflection);

        if (!$cfg) {
            return $obj;
        }

        return $this->populateObject($reflection, $obj, $cfg, $group);
    }

    protected function populateObject(\ReflectionClass $reflection, $object, MainAnnotation $objectConfiguration, $group = null)
    {
        $props = $reflection->getProperties();

        foreach ($props as $prop) {

            $metadata = $this->metadataFactory->create($object, $objectConfiguration, $prop);
            if (!$metadata) {
                continue;
            }

            if ($group && !in_array($group, (array)$metadata->configuration->groups)) {
                continue;
            }

            $value = $this->generatorChain->getValueForField($metadata);
            $value = $this->decoratorChain->getDecoratedValue($value, $metadata);

            Accessor::setPropertyValue($object, $prop->getName(), $value);
        }

        return $object;
    }

    protected function getClass($objectOrClass, $newObjectArguments = [])
    {

        if (is_object($objectOrClass)) {
            return $objectOrClass;
        }

        return new $objectOrClass(...(array)$newObjectArguments);

    }

}