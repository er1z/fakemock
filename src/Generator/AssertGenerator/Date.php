<?php


namespace Er1z\FakeMock\Generator\AssertGenerator;


use Er1z\FakeMock\Metadata\FieldMetadata;
use Faker\Generator;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\Validator\Constraint;

class Date implements GeneratorInterface
{

    public function generateForProperty(FieldMetadata $field, Constraint $constraint, Generator $faker)
    {
        /**
         * @var \Symfony\Component\Validator\Constraints\Date $constraint
         */
        $date = $faker->date();

        if($field->type instanceof String_){
            return $date;
        }

        return new \DateTime($date);
    }
}