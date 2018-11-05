<?php
namespace Tests\Er1z\FakeMock\Mocks;

use Er1z\FakeMock\Annotations\FakeMock as FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class StructBasic
 * @FakeMock()
 */
class StructBasic
{

    /**
     * @FakeMockField()
     */
    public $stringAuto;

    /**
     * @FakeMockField(method="name")
     */
    public $stringName;

    /**
     * @FakeMockField(method="randomFloat", options={null, 0, 10})
     * @var float
     */
    public $float;

    /**
     * @FakeMockField()
     * @var float
     */
    public $floatAuto;

    /**
     * @FakeMockField()
     * @Assert\Choice(choices={"one", "two", "three"})
     * @var string
     */
    public $choice;

}