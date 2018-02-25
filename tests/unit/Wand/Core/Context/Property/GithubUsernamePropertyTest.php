<?php

namespace PlanB\Wand\Core\Context\Property;

use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;


/**
 * GithubUsernameProperty Class Test
 * @coversDefaultClass PlanB\Wand\Core\Context\Property\GithubUsernameProperty
 */
class GithubUsernamePropertyTest extends Unit
{


    use Mocker;

    /**
     * @var  \UnitTester $tester
     */
    protected $tester;

    /**
     * @test
     *
     * @covers ::resolve
     */
    public function testResolve()
    {
        /** @var GithubUsernameProperty $target */
        $target = GithubUsernameProperty::create();

        $this->tester->assertEquals('username', $target->resolve('https://github.com/username/'));

        $this->tester->assertNull($target->resolve('no-format'));


    }


}