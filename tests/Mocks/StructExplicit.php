<?php
namespace Tests\Er1z\FakeMock\Mocks;

use Er1z\FakeMock\Annotations\FakeMock as FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class StructBasic
 * @FakeMock()
 */
class StructExplicit
{

    /**
     * @FakeMockField(value="test value")
     * @var string
     */
    public $value;

    /**
     * @FakeMockField(regex="\d{2}\-\d{3}")
     * @var string
     */
    public $regex;

    /**
     * @FakeMockField(faker="name")
     * @var string
     */
    public $fakedName;

}