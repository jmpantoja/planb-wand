<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\App;

use PlanB\Utils\Dev\Tdd\Test\Unit;
use PlanB\Wand\Core\Path\PathManager;
use PlanB\Wand\Core\Task\TaskManager;


/**
 * Class AppManagerTest
 *
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\App\AppManager
 */
class AppManagerTest extends Unit
{

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::init
     * @covers ::getDefaultPath
     * @covers ::getCustomPath
     */
    public function testInit()
    {

        $taskManager = $this->mock(TaskManager::class, [
            'setTasks' => $this->make(TaskManager::class)
        ]);

        $pathManager = $this->make(PathManager::class);
        $pathManager->build(null);

        $manager = new AppManager($taskManager->make(), $pathManager);
        $this->assertAttributeInstanceOf(TaskManager::class, 'taskManager', $manager);
        $this->assertAttributeInstanceOf(PathManager::class, 'pathManager', $manager);

        $manager->init();

        $taskManager->verify('setTasks', 1);

    }

}