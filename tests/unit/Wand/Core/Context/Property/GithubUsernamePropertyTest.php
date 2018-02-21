<?php

namespace PlanB\Wand\Core\Context\Property;

use PlanB\Utils\Dev\Tdd\Test\Unit;

use PlanB\Utils\Tdd\Mock\Double;


/**
 * GithubUsernameProperty Class Test
 * @coversDefaultClass PlanB\Wand\Core\Context\Property\GithubUsernameProperty
 */
class GithubUsernamePropertyTest extends Unit
{


    /**
     * @test
     *
     * @covers ::resolve
     */
    public function testResolve()
    {
        /** @var GithubUsernameProperty $target */
        $target = GithubUsernameProperty::create();

        $this->assertEquals('username', $target->resolve('https://github.com/username/'));

        $this->assertNull($target->resolve('no-format'));


    }


}