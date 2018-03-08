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
use PlanB\Utils\Dev\Tdd\Data\Data;
use PlanB\Utils\Dev\Tdd\Data\Provider;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\Context\Exception\UnknowParamException;
use PlanB\Wand\Core\Context\Exception\UnknowPathException;
use PlanB\Wand\Core\Git\GitManager;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

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
            'src' => realpath('.') . '/src'
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


    /**
     * @test
     * @covers ::updateLastExecution
     */
    public function testUpdateLastExecution()
    {
        $cache = $this->double(ContextCache::class);

        $context = Context::create([], [
            'project' => realpath('.')
        ]);
        $context->updateLastExecution();
        $cache->verifyInvokedOnce('update');
    }


    /**
     * @test
     * @covers ::getModifiedFiles
     */
    public function testGetModifiedFiles()
    {
        $this->double(ContextCache::class, [
            'filter' => function (SplFileInfo $fileInfo) {
                return $fileInfo->getBasename() == 'ContextManager.php';
            }
        ]);

        $context = Context::create([], [
            'project' => realpath('.'),
            'src' => realpath('.') . '/src',
            'target' => realpath('.') . '/src'
        ]);

        $files = $context->getModifiedFiles('src');

        $this->assertEquals([
            'src/Wand/Core/Context/ContextManager.php'
        ], $files);
    }

    /**
     * @test
     *
     * @dataProvider providerRelativePath
     *
     * @covers ::getPathRelativeTo
     */
    public function testRelativePath(Data $data)
    {
        $context = Context::create([], [
            'project' => realpath('.'),
            'src' => realpath('.') . '/src',
            'target' => realpath('.') . '/src/path'
        ]);

        $this->tester->assertEquals($data->expected, $context->getPathRelativeTo($data->absolute, $data->base));
    }

    public function providerRelativePath()
    {
        $absolute = sprintf('%s/src/path/to/fileA.php', realpath('.'));

        return Provider::create()
            ->add([
                'base' => 'project',
                'absolute' => $absolute,
                'expected' => 'src/path/to/fileA.php'
            ])
            ->add([
                'base' => 'src',
                'absolute' => $absolute,
                'expected' => 'path/to/fileA.php'
            ])
            ->add([
                'base' => 'target',
                'absolute' => $absolute,
                'expected' => 'to/fileA.php'
            ])
            ->end();
    }

}