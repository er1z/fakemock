<?php
namespace Tests\Er1z\FakeMock\Mocks;

use Er1z\FakeMock\Annotations\FakeMock as FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField as FakeMockField;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class StructBasic
 * @FakeMock()
 */
class StructWithAsserts
{

    /**
     * @FakeMockField()
     */
    public $stringAuto;

    /**
     * @FakeMockField()
     * @Assert\Range(min=10, max=255)
     * @var float
     */
    public $floatAuto;

}