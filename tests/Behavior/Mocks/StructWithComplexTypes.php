<?php
namespace Tests\Er1z\FakeMock\Behavior\Mocks;

use Er1z\FakeMock\Annotations\FakeMock as FakeMock;
use Er1z\FakeMock\Annotations\FakeMockField;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class StructBasic
 * @FakeMock()
 */
class StructWithComplexTypes
{

    /**
     * @FakeMockField()
     * @var string
     * @Assert\Date()
     */
    public $date;

    /**
     * @FakeMockField()
     * @var string
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

    /**
     * @var string
     * @FakeMockField()
     * @Assert\Ip(version="4")
     */
    public $ipv4;

    /**
     * @var string
     * @FakeMockField()
     * @Assert\Ip(version="6")
     */
    public $ipv6;

    /**
     * @var string
     * @FakeMockField()
     * @Assert\Ip(version="all")
     */
    public $ipvAll;
}