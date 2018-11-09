<?php

namespace Er1z\FakeMock\Generator;

use Er1z\FakeMock\Metadata\FieldMetadata;
use Symfony\Component\Validator\Constraint;

class GeneratorChain implements GeneratorChainInterface
{
    /**
     * @var GeneratorInterface[]
     */
    private $generators;

    /**
     * DetectorChain constructor.
     *
     * @param GeneratorInterface[] $detectors
     */
    public function __construct($detectors = [])
    {
        if (!$detectors) {
            $detectors = self::getDefaultDetectorsSet();
        }

        foreach ($detectors as $d) {
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
    public static function getDefaultDetectorsSet()
    {
        $result = [
            new TypedGenerator(),
        ];

        if (class_exists(Constraint::class)) {
            $result[] = new AssertGenerator();
        }

        $result[] = new FakerGenerator();
        $result[] = new LastResortGenerator();

        return $result;
    }

    public function getValueForField(
        FieldMetadata $field
    ) {
        foreach ($this->generators as $d) {
            $result = $d->generateForProperty($field);
            if (!is_null($result)) {
                return $result;
            }
        }

        return null;
    }
}
