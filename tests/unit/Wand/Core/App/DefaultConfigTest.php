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

use PlanB\Utils\Dev\Tdd\Test\Data\Data;
use PlanB\Utils\Dev\Tdd\Test\Data\Provider;
use PlanB\Utils\Dev\Tdd\Test\Unit;
use PlanB\Utils\Path\Path;
use Symfony\Component\Yaml\Yaml;

/**
 * Class CustomConfigTest
 * @package PlanB\Wand\Core\App
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\App\DefaultConfig
 */
class DefaultConfigTest extends Unit
{
    /**
     * @test
     * @dataProvider providerProcess
     *
     * @covers ::getConfigTree
     * @covers ::defineTasks
     * @covers ::getClassNameNode
     * @covers ::getDescriptionNode
     * @covers ::getActionsNode
     * @covers ::getActionGroupNode
     * @covers ::getParamsNode
     *
     * @covers ::processWithFilter
     *
     * @covers       \PlanB\Wand\Core\App\BaseConfig::__construct
     * @covers       \PlanB\Wand\Core\App\BaseConfig::create
     * @covers       \PlanB\Wand\Core\App\BaseConfig::process
     * @covers       \PlanB\Wand\Core\App\BaseConfig::readFromFile
     */
    public function testProcess(Data $data)
    {
        $file = $data->file;

        $path = Path::create(__DIR__, 'configs/default', sprintf('%s.yml', $file));
        $expectedPath = Path::create(__DIR__, 'configs/default', sprintf('%s.expected.yml', $file));
        $expected = Yaml::parseFile($expectedPath);

        $config = DefaultConfig::create($path)
            ->processWithFilter([
                'tasks' => [
                    'init' => [
                        'readme' => true
                    ],
                    'taskB' => []
                ]
            ]);

        $this->assertEquals($expected, $config);

    }

    public function providerProcess()
    {
        return Provider::create()
            ->add([
                'file' => 'valid'
            ])
            ->add([
                'file' => 'default_values'
            ])
            ->end();
    }


}