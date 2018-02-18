<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Config;

use PlanB\Utils\Dev\Tdd\Test\Unit;
use PlanB\Wand\Core\Path\PathManager;
use PlanB\Wand\Core\Task\TaskManager;


/**
 * Class AppManagerTest
 *
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Config\ConfigManager
 */
class ConfigManagerTest extends Unit
{

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::getTasks
     * @covers ::getDefaultPath
     * @covers ::getCustomPath
     */
    public function testInit()
    {
        $pathManager = $this->make(PathManager::class);
        $pathManager->build(null);

        $manager = new ConfigManager($pathManager);

        $this->assertAttributeInstanceOf(PathManager::class, 'pathManager', $manager);

        $manager->getTasks();

    }

}