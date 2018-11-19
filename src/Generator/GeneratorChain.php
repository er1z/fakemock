<?php

namespace Er1z\FakeMock\Generator;

use Er1z\FakeMock\FakeMock;
use Er1z\FakeMock\Metadata\FieldMetadata;
use Symfony\Component\Validator\Constraint;

class GeneratorChain implements GeneratorChainInterface
{
    /**
     * @var GeneratorInterface[]
     */
    private $generators;

    /**
     * @param GeneratorInterface[] $generators
     */
    public function __construct($generators = [])
    {
        if (!$generators) {
            $generators = self::getDefaultGeneratorsSet();
        }

        foreach ($generators as $d) {
            $this->addGenerator($d);
        }
    }

    public function addGenerator(GeneratorInterface $detector)
    {
        $this->generators[] = $detector;
    }

    /**
     * @return GeneratorInterface[];
     */
    public static function getDefaultGeneratorsSet()
    {
        $result = [
            new TypedGenerator(),
        ];

        if (class_exists(Constraint::class)) {
            $result[] = new AssertGenerator();
        }

        $result[] = new RecursiveGenerator();
        $result[] = new FakerGenerator();
        $result[] = new PhpDocGenerator();
        $result[] = new LastResortGenerator();

        return $result;
    }

    public function getValueForField(
        FieldMetadata $field, FakeMock $fakemock, ?string $group = null
    ) {
        foreach ($this->generators as $d) {
            $result = $d->generateForProperty($field, $fakemock, $group);
            if (!is_null($result)) {
                return $result;
            }
        }

        return null;
    }
}
