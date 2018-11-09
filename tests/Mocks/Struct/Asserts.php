<?php
namespace Tests\Er1z\FakeMock\Mocks\Struct;

use Er1z\FakeMock\Annotations\FakeMock as FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField as FakeMockField;
use Symfony\Component\Validator\Constraints as Assert;

/**
  * @FakeMock()
 */
class Asserts
{

    /**
     * @FakeMockField()
     * @Assert\Range(min=10, max=255)
     * @var float
     */
    public $floatAssert;

    /**
     * @FakeMockField()
     * @Assert\Regex(pattern="[0-9]{2}\-[0-9]{3}")
     */
    public $postcode;

    /**
     * @FakeMockField()
     * @var string
     * @Assert\Date()
     */
    public $dateString;

    /**
     * @FakeMockField()
     * @Assert\Date()
     */
    public $date;

    /**
     * @FakeMockField()
     * @var string
     * @Assert\DateTime()
     */
    public $dateTimeString;

    /**
     * @FakeMockField()
     * @Assert\DateTime()
     */
    public $dateTime;

    /**
     * @var string
     * @FakeMockField()
     * @Assert\Time()
     */
    public $time;

    /**
     * @var string
     * @FakeMockField()
     * @Assert\Email()
     */
    public $email;

    /**
     * @var string
     * @FakeMockField()
     * @Assert\Url()
     */
    public $url;

}