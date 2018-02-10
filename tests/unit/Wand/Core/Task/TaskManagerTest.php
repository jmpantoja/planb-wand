<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Spine\Core\Task;

use PlanB\Utils\Dev\Tdd\Test\Unit;
use PlanB\Utils\Path\Path;
use PlanB\Wand\Core\Path\PathManager;
use PlanB\Wand\Core\Task\TaskManager;

/**
 * Class TaskManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Task\TaskManager
 */
class TaskManagerTest extends Unit
{

    /**
     * @covers ::__construct
     * @covers ::runTask
     * @covers ::configure
     */
    public function testRunTask()
    {

        $pathManager = $this->make(PathManager::class);

        $manager = new TaskManager($pathManager);
        $manager->runTask('task', realpath('.'), false);

        $this->assertAttributeInstanceOf(PathManager::class, 'pathManager', $manager);
    }

}