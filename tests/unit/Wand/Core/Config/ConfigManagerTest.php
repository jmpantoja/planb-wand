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

        $this->assertArrayHasKey('composer/validate', $tasks);
        $this->assertArrayHasKey('init/ci', $tasks);
        $this->assertArrayHasKey('init/git', $tasks);
        $this->assertArrayHasKey('init/qa', $tasks);
        $this->assertArrayHasKey('qa', $tasks);
        $this->assertArrayHasKey('init', $tasks);
        $this->assertArrayHasKey('validate', $tasks);
        $this->assertArrayHasKey('init/sami', $tasks);
        $this->assertArrayHasKey('init/project', $tasks);
        $this->assertArrayHasKey('init/info', $tasks);
        $this->assertArrayHasKey('init/codecept', $tasks);
        $this->assertArrayHasKey('tdd/unit', $tasks);
        $this->assertArrayHasKey('sami', $tasks);

        $this->assertCount(13, $tasks);

    }

}