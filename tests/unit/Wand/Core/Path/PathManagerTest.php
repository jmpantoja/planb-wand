<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Path;

use PlanB\Utils\Dev\Tdd\Test\Unit;


/**
 * Class TaskManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Path\PathManager
 */
class PathManagerTest extends Unit
{

    /**
     * @covers ::build
     * @covers ::findProjectDir
     */
    public function testBuild()
    {
        $manager = new PathManager();
        $manager->build(realpath('.'));

        $this->assertAttributeEquals(realpath('.'), 'projectDir', $manager);
    }

    /**
     * @covers ::build
     * @covers ::findProjectDir
     *
     * @covers \PlanB\Wand\Core\Path\Exception\InvalidProjectDirectoryException::notFound
     *
     * @expectedException \PlanB\Wand\Core\Path\Exception\InvalidProjectDirectoryException
     * @expectedExceptionMessage La ruta '/path/to/fake/dir' no existe
     */
    public function testExceptionNotFound()
    {
        $manager = new PathManager();
        $manager->build('/path/to/fake/dir');

    }

    /**
     * @covers ::build
     * @covers ::findProjectDir
     *
     * @covers \PlanB\Wand\Core\Path\Exception\InvalidProjectDirectoryException::composerMissing()
     *
     * @expectedException \PlanB\Wand\Core\Path\Exception\InvalidProjectDirectoryException
     * @expectedExceptionMessage No se encuentra el archivo composer.json en el directorio
     * @expectedExceptionMessage ni en ninguno de sus padres
     */
    public function testExceptionComposerMissing()
    {
        $manager = new PathManager();
        $manager->build(dirname(realpath('.')));
    }

    public function testProjectDir()
    {
        $manager = new PathManager();
        $manager->build(realpath('.'));

        $this->assertEquals(realpath('.'), $manager->projectDir());
    }

}