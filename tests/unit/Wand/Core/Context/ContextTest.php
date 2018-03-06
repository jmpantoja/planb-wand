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
use PlanB\Wand\Core\Context\Exception\UnknowParamException;
use PlanB\Wand\Core\Context\Exception\UnknowPathException;
use PlanB\Wand\Core\Git\GitManager;

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
     * @covers ::getParam
     *
     * @covers ::getPath
     *
     * @covers ::getGitManager
     *
     * @covers \PlanB\Wand\Core\Context\Exception\UnknowPathException::create
     * @covers \PlanB\Wand\Core\Context\Exception\UnknowParamException::create
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
            'project' => realpath('.'),
        ];

        $context = Context::create($params, $paths);

        $this->tester->assertEquals($params, $context->getParams());

        $this->tester->assertEquals('valueA', $context->getParam('keyA'));
        $this->tester->assertEquals('valueB', $context->getParam('keyB'));
        $this->tester->assertEquals('valueC', $context->getParam('keyC'));

        $this->tester->expectException(UnknowParamException::class, function () use ($context) {
            $context->getParam('paramXXX');
        });

        $this->tester->assertEquals('valueA', $context->getPath('pathA'));
        $this->tester->assertEquals('valueB', $context->getPath('pathB'));
        $this->tester->assertEquals('valueC', $context->getPath('pathC'));
        $this->tester->assertEquals(realpath('.'), $context->getPath('project'));

        $this->tester->expectException(UnknowPathException::class, function () use ($context) {
            $context->getPath('pathXXX');
        });

        $this->tester->assertInstanceOf(GitManager::class, $context->getGitManager());
    }

}