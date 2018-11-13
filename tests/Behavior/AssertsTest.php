<?php

namespace Tests\Er1z\FakeMock\Behavior;

use Er1z\FakeMock\FakeMock;
use PHPUnit\Framework\TestCase;
use Tests\Er1z\FakeMock\AssertsTestTrait;
use Tests\Er1z\FakeMock\Mocks\Struct\Asserts;

class AssertsTest extends TestCase
{

    use AssertsTestTrait;

    public function testAsserts()
    {
        $f = new FakeMock();

        $obj = new Asserts();

        $f->fill($obj);

        $this->assertInternalType('float', $obj->floatAssert);
        $this->assertRegExp('#[0-9]{2}\-[0-9]{3}#si', $obj->postcode);

        $this->assertGreaterThan(0, strtotime($obj->dateString));
        $this->assertInstanceOf(\DateTimeInterface::class, $obj->date);

        $this->assertGreaterThan(0, strtotime($obj->dateTimeString));
        $this->assertInstanceOf(\DateTimeInterface::class, $obj->dateTime);

        $this->assertRegExp('#\d{2}\:\d{2}\:\d{2}#si', $obj->time);

        $this->assertNotNull(filter_var($obj->email, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE));

        $this->assertNotNull(filter_var($obj->url, FILTER_VALIDATE_URL, FILTER_NULL_ON_FAILURE));
    }
}
