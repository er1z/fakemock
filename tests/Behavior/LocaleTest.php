<?php

namespace Tests\Er1z\FakeMock\Behavior;

use Er1z\FakeMock\FakeMock;
use Faker\Provider\pl_PL\Person;
use PHPUnit\Framework\TestCase;
use Tests\Er1z\FakeMock\Mocks\Struct\LocaleField;
use Tests\Er1z\FakeMock\Mocks\Struct\LocaleStruct;

class LocaleTest extends TestCase
{
    protected function getNames()
    {
        $names = function () {
            // oops, IDEs are going crazy in here
            return array_merge(
                Person::$firstNameMale,
                Person::$firstNameFemale
            );
        };

        $namesFunc = \Closure::bind($names, null, Person::class);

        return $namesFunc();
    }

    public function testWholeClass()
    {
        $f = new FakeMock();
        $struct = new LocaleStruct();

        $result = $f->fill($struct);

        $namesString = implode(' ', $this->getNames());

        $found = false;
        foreach (explode(' ', $struct->name) as $str) {
            if (false !== strpos($namesString, $str)) {
                $found = true;
            }
        }
        $this->assertTrue($found);
    }

    public function testParticularField()
    {
        $f = new FakeMock();
        $struct = new LocaleField();

        $result = $f->fill($struct);

        $namesString = mb_strtolower(implode(' ', $this->getNames()));

        $found = false;
        foreach (explode(' ', $struct->name) as $str) {
            if (false !== strpos($namesString, mb_strtolower($str))) {
                $found = true;
            }
        }
        $this->assertTrue($found);

    }
}
