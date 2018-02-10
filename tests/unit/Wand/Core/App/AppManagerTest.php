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
     * @covers ::build
     */
    public function testBuild()
    {
        $pathManager = $this->mock(PathManager::class, [
            'build' => null
        ]);

        $manager = new AppManager($pathManager->make());
        $manager->build(realpath('.'));


        $pathManager->verify('build', 1, [realpath('.')]);
    }

}