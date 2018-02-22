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

use PlanB\Utils\Dev\Tdd\Test\Unit;
use PlanB\Wand\Core\Action\Action;
use PlanB\Wand\Core\Path\PathManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;


/**
 * Class TaskManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\File\File
 */
class FileTest extends Unit
{

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::create
     *
     * @covers ::getChmod
     * @covers ::getAction
     * @covers ::getTemplate
     * @covers ::getTarget
     * @covers ::getGroup
     *
     * @covers ::getPath
     * @covers ::exists
     *
     */
    public function create()
    {
        $pathManager = $this->make(PathManager::class, [
            'projectDir' => '/path/to/project'
        ]);

        $container = new ContainerBuilder();
        $container->set('wand.path.manager', $pathManager);


        $file = File::create([
            'group' => 'metainfo',
            'params' => [
                'template' => '@wand.metainfo.readme.twig',
                'target' => 'README.md'
            ]
        ]);

        $file->setContainer($container);

        $this->assertInstanceOf(File::class, $file);

        $this->assertEquals(0644, $file->getChmod());
        $this->assertEquals('create', $file->getAction());
        $this->assertEquals('@wand.metainfo.readme.twig', $file->getTemplate());
        $this->assertEquals('README.md', $file->getTarget());
        $this->assertEquals('/path/to/project/README.md', $file->getPath());
        $this->assertFalse($file->exists());

        $this->assertEquals('metainfo', $file->getGroup());
    }
}