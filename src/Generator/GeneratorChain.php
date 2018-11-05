<?php


namespace Er1z\FakeMock\Generator;


use Er1z\FakeMock\Annotations\AnnotationCollection;
use Er1z\FakeMock\Annotations\FakeMockField;
use Symfony\Component\Validator\Constraint;

class GeneratorChain implements GeneratorChainInterface
{
    /**
     * @var GeneratorInterface[]
     */
    private $detectors;

    /**
     * DetectorChain constructor.
     * @param GeneratorInterface[] $detectors
     */
    public function __construct($detectors = [])
    {
        if (!$detectors) {
            $detectors = self::getDefaultDetectorsSet();
        }

        foreach ($detectors as $d) {
            $this->addDetector($d);
        }
    }

    public function addDetector(GeneratorInterface $detector)
    {
        $this->detectors[] = $detector;
    }

    /**
     * @return GeneratorInterface[];
     */
    public static function getDefaultDetectorsSet()
    {
        $result = [
            new TypedGenerator()
        ];

        if (class_exists(Constraint::class)) {
            $result[] = new AssertGenerator();
        }

        $result[] = new FakerGenerator();
        $result[] = new LastResortGenerator();
        return $result;
    }

    public function getValueForField(
        $object, \ReflectionProperty $property, FakeMockField $configuration, AnnotationCollection $annotations
    )
    {
        foreach ($this->detectors as $d) {
            if ($result = $d->generateForProperty($object, $property, $configuration, $annotations)) {
                return $result;
            }
        }

        return null;
    }

}