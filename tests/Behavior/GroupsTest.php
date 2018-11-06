<?php


namespace Tests\Er1z\FakeMock\Behavior;


use Er1z\FakeMock\FakeMock;
use PHPUnit\Framework\TestCase;
use Tests\Er1z\FakeMock\Behavior\Mocks\WithGroups;

class GroupsTest extends TestCase
{

    public function testGroups()
    {
        $mocker = new FakeMock();

        $all = new WithGroups();
        $mocker->fill($all);

        $this->assertGreaterThanOrEqual(1, substr_count($all->stringOne, ' '));
        $this->assertGreaterThanOrEqual(1, substr_count($all->stringTwo, ' '));

        $first = new WithGroups();
        $mocker->fill($first, 'first');

        $this->assertGreaterThanOrEqual(1, substr_count($first->stringOne, ' '));
        $this->assertNull($first->stringTwo);

        $second = new WithGroups();
        $mocker->fill($second, 'second');

        $this->assertNull($second->stringOne);
        $this->assertGreaterThanOrEqual(1, substr_count($second->stringTwo, ' '));

    }

}