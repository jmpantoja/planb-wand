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
use PlanB\Utils\Dev\Tdd\Data\Data;
use PlanB\Utils\Dev\Tdd\Data\Provider;


use PlanB\Wand\Core\Config\Exception\UndefinidedActionNameException;
use PlanB\Wand\Core\Config\Exception\UndefinidedTaskNameException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class CustomConfigTest
 * @package PlanB\Wand\Core\Config
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Config\ConfigFilter
 */
class ConfigFilterTest extends Unit
{

    use Mocker;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @test
     * @dataProvider providerProcess
     *
     */
    public function testFilter(Data $data)
    {

        $data->expectException($data->exception, function (Data $data) {
            $default = $data->default;
            $custom = $data->custom;
            $expected = $data->expected;

            $response = ConfigFilter::create($default, $custom)
                ->process();

            $this->tester->assertEquals($expected['tasks'], $response);
        }, $this->tester);


    }

    public function providerProcess()
    {
        return Provider::create()
            ->add([
                'default' => $this->fromFile('original'),
                'custom' => $this->fromFile('complete'),
                'expected' => $this->fromFile('complete.expected'),
                'exception' => null
            ], 'complete')
            ->add([
                'default' => $this->fromFile('original'),
                'custom' => $this->fromFile('task_unset'),
                'expected' => $this->fromFile('task_unset.expected'),
                'exception' => null
            ], 'task_unset')
            ->add([
                'default' => $this->fromFile('original'),
                'custom' => $this->fromFile('action_unset'),
                'expected' => $this->fromFile('action_unset.expected'),
                'exception' => null
            ], 'action_unset')
            ->add([
                'default' => $this->fromFile('original'),
                'custom' => $this->fromFile('extra_tasks'),
                'expected' => $this->fromFile('extra_tasks.expected'),
                'exception' => UndefinidedTaskNameException::class
            ], 'extra_tasks')
            ->add([
                'default' => $this->fromFile('original'),
                'custom' => $this->fromFile('extra_tasks_single'),
                'expected' => $this->fromFile('extra_tasks_single.expected'),
                'exception' => UndefinidedTaskNameException::class
            ], 'extra_tasks_single')
            ->add([
                'default' => $this->fromFile('original'),
                'custom' => $this->fromFile('extra_actions'),
                'expected' => $this->fromFile('extra_actions.expected'),
                'exception' => UndefinidedActionNameException::class
            ], 'extra_actions')
            ->add([
                'default' => $this->fromFile('original'),
                'custom' => $this->fromFile('extra_actions_single'),
                'expected' => $this->fromFile('extra_actions_single.expected'),
                'exception' => UndefinidedActionNameException::class
            ], 'extra_actions')
            ->end();
    }


    private function fromFile(string $name): array
    {
        $data = ['tasks' => []];
        $path = sprintf('%s/configs/filter/%s.yml', __DIR__, $name);
        if (is_file($path)) {
            $data = Yaml::parseFile($path);
        }

        return $data;

    }


}