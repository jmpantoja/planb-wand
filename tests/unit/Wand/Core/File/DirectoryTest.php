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
 * @coversDefaultClass \PlanB\Wand\Core\File\Directory
 */
class DirectoryTest extends Unit
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
     * @covers ::getProfile
     * @covers ::getPath
     *
     */
    public function testCreate()
    {
        $context = $this->stub(Context::class);

        $context->expects()
            ->getPath('project')
            ->once()
            ->andReturn('/path/to/project/');

        $directory = Directory::create([
            'group' => 'metainfo',
            'params' => [
                'target' => 'src'
            ]
        ]);
        $directory->setContext($context);

        $this->tester->assertEquals('/path/to/project/src/.gitkeep', $directory->getPath());
        $this->tester->assertEquals('without-template', $directory->getProfile());
    }
}