<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Context;


use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\Context\Exception\UnknowPathException;

/**
 * Class ContextTest
 * @package PlanB\Wand\Core\Context
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Context\Context
 */
class ContextTest extends Unit
{

    use Mocker;

    /**
     * @var  \UnitTester $tester
     */
    protected $tester;

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::create
     *
     * @covers ::getParams
     * @covers ::getPath
     *
     * @covers \PlanB\Wand\Core\Context\Exception\UnknowPathException::create
     */
    public function testCreate()
    {

        $params = [
            'keyA' => 'valueA',
            'keyB' => 'valueB',
            'keyC' => 'valueC',
        ];

        $paths = [
            'pathA' => 'valueA',
            'pathB' => 'valueB',
            'pathC' => 'valueC',
        ];


        $context = Context::create($params, $paths);

        $this->tester->assertEquals($params, $context->getParams());
        $this->tester->assertEquals('valueA', $context->getPath('pathA'));
        $this->tester->assertEquals('valueB', $context->getPath('pathB'));
        $this->tester->assertEquals('valueC', $context->getPath('pathC'));

        $this->tester->expectException(UnknowPathException::class, function () use ($context) {
            $context->getPath('pathXXX');
        });
    }

}