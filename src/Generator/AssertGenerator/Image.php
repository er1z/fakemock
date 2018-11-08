<?php


namespace Er1z\FakeMock\Generator\AssertGenerator;


use Er1z\FakeMock\Metadata\FieldMetadata;
use Faker\Generator;
use Symfony\Component\Validator\Constraint;

class Image implements GeneratorInterface
{

    const DEFAULT_WIDTH = 640;
    const DEFAULT_HEIGHT = 480;

    public function generateForProperty(FieldMetadata $field, Constraint $constraint, Generator $faker)
    {
        /**
         * @var \Symfony\Component\Validator\Constraints\Image $constraint
         */

        $width = $constraint->maxWidth ?: self::DEFAULT_WIDTH;
        $height = $constraint->maxHeight ?: self::DEFAULT_HEIGHT;

        return new \SplFileObject($faker->image(null, $width, $height));
    }
}