<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\File;

use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\Context\Context;
use PlanB\Wand\Core\Path\PathManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;


/**
 * Class TaskManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\File\File
 */
class FileTest extends Unit
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
     * @covers ::getProfile
     *
     * @covers ::getChmod
     * @covers ::getAction
     * @covers ::getTemplate
     * @covers ::getTarget
     * @covers ::getGroup
     * @covers ::getVars
     *
     * @covers ::getPath
     * @covers ::exists
     *
     */
    public function testCreate()
    {
        $this->stub(PathManager::class, [
            'projectDir' => '/path/to/project'
        ]);

        $context = $this->stub(Context::class, [
            'getParams' => [
                'keyA' => 'valueA',
                'keyB' => 'valueB',
                'keyC' => 'valueC',
            ]
        ]);

        $context->expects()
            ->getPath('project')
            ->twice()
            ->andReturn('/path/to/project/');


        $file = File::create([
            'group' => 'metainfo',
            'params' => [
                'template' => '@wand.metainfo.readme.twig',
                'target' => 'README.md'
            ]
        ]);

        $file->setContext($context);

        $this->tester->assertEquals('standard', $file->getProfile());

        $this->tester->assertInstanceOf(File::class, $file);

        $this->tester->assertEquals(0644, $file->getChmod());
        $this->tester->assertEquals('create', $file->getAction());
        $this->tester->assertEquals('@wand.metainfo.readme.twig', $file->getTemplate());
        $this->tester->assertEquals('README.md', $file->getTarget());
        $this->tester->assertEquals('/path/to/project/README.md', $file->getPath());

        $this->tester->assertEquals([
            'keyA' => 'valueA',
            'keyB' => 'valueB',
            'keyC' => 'valueC',
        ], $file->getVars());

        $this->tester->assertFalse($file->exists());

        $this->tester->assertEquals('Metainfo', $file->getGroup());
    }
}