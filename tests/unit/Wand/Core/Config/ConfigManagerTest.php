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

use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\Path\PathManager;


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

    use Mocker;

    /**
     * @var  \UnitTester $tester
     */
    protected $tester;

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::getConfig
     * @covers ::getDefaultPaths
     * @covers ::getCustomPath
     */
    public function testInit()
    {
        $pathManager = $this->stub(PathManager::class, [
            'projectDir' => realpath('.')
        ]);


        $manager = new ConfigManager($pathManager);

        $this->assertAttributeInstanceOf(PathManager::class, 'pathManager', $manager);

        $config = $manager->getConfig();
        $tasks = $config['tasks'];

        $this->tester->assertEquals([
            'init'

        ], array_keys($tasks));

    }

}