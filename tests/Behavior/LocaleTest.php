<?php


namespace Tests\Er1z\FakeMock\Behavior;


use Er1z\FakeMock\FakeMock;
use PHPUnit\Framework\TestCase;
use Tests\Er1z\FakeMock\Mocks\Struct\LocaleField;
use Tests\Er1z\FakeMock\Mocks\Struct\LocaleStruct;

class LocaleTest extends TestCase
{

    public function testWholeClass()
    {
        $f = new FakeMock();
        $struct = new LocaleStruct();

        $result = $f->fill($struct);
    }

    public function testParticularField()
    {
        $f = new FakeMock();
        $struct = new LocaleField();

        $result = $f->fill($struct);
    }

}