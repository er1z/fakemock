<?php

namespace Er1z\FakeMock\Generator\AssertGenerator;

use Er1z\FakeMock\Metadata\FieldMetadata;
use Faker\Generator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Ip as IpConstraint;

class Ip implements GeneratorInterface
{
    public function generateForProperty(FieldMetadata $field, Constraint $constraint, Generator $faker)
    {
        /**
         * @var IpConstraint
         */
        switch ($constraint->version) {
            case IpConstraint::V6:
            case IpConstraint::V6_NO_PRIV:
            case IpConstraint::V6_NO_RES:
            case IpConstraint::V6_ONLY_PUBLIC:
                return $faker->ipv6;

            default:
            case IpConstraint::V4:
            case IpConstraint::V4_NO_PRIV:
            case IpConstraint::V4_NO_RES:
            case IpConstraint::V4_ONLY_PUBLIC:
                return $faker->ipv4;

            case IpConstraint::ALL:
            case IpConstraint::ALL_NO_PRIV:
            case IpConstraint::ALL_NO_RES:
            case IpConstraint::ALL_ONLY_PUBLIC:
                return $faker->{mt_rand(0, 1) ? 'ipv4' : 'ipv6'};
        }
    }
}
