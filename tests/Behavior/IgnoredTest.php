<?php


namespace Tests\Er1z\FakeMock\Behavior;


use Er1z\FakeMock\FakeMock;
use PHPUnit\Framework\TestCase;
use Tests\Er1z\FakeMock\Behavior\Mocks\StructIgnored;

class IgnoredTest extends TestCase
{

    public function testIgnored()
    {
        $f = new FakeMock();

        $obj = new StructIgnored();

        $f->fill($obj);

        $this->assertNull($obj->string);
    }

}