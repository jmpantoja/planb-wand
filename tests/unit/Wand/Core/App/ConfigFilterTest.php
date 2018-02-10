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
use PlanB\Wand\Core\App\Exception\UndefinidedTaskNameException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class CustomConfigTest
 * @package PlanB\Wand\Core\App
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\App\ConfigFilter
 */
class ConfigFilterTest extends Unit
{
    /**
     * @test
     * @dataProvider providerProcess
     *
     */
    public function testFilter(Data $data)
    {
        $file = $data->file;

        $default = $this->fromFile('original');
        $custom = $this->fromFile($file);
        $expected = $this->fromFile($file . '.expected');

        $response = ConfigFilter::create($default, $custom)
            ->process();


        $this->assertEquals($expected['tasks'], $response);

    }

    public function providerProcess()
    {
        return Provider::create()
            ->add([
                'file' => 'complete'
            ], 'complete')
            ->add([
                'file' => 'task_unset'
            ], 'task unset')
            ->add([
                'file' => 'action_unset'
            ], 'action unset')
            ->end();
    }


    /**
     * @test
     *
     * @dataProvider providerExtraTaskException
     *
     * @expectedException \PlanB\Wand\Core\App\Exception\UndefinidedTaskNameException
     */
    public function testExtraTaskException(Data $data)
    {

        $file = $data->file;

        $default = $this->fromFile('original');
        $custom = $this->fromFile($file);
        $expected = $this->fromFile($file . '.expected');

        $response = ConfigFilter::create($default, $custom)
            ->process();


        $this->assertEquals($expected['tasks'], $response);

    }

    public function providerExtraTaskException()
    {
        return Provider::create()
            ->add([
                'file' => 'extra_tasks'
            ], 'extra tasks')
            ->add([
                'file' => 'extra_tasks_single'
            ], 'extra tasks single')
            ->end();
    }

    /**
     * @test
     *
     * @dataProvider providerExtraActionException
     *
     * @expectedException \PlanB\Wand\Core\App\Exception\UndefinidedActionNameException
     */
    public function testExtraActionException(Data $data)
    {

        $file = $data->file;

        $default = $this->fromFile('original');
        $custom = $this->fromFile($file);
        $expected = $this->fromFile($file . '.expected');

        $response = ConfigFilter::create($default, $custom)
            ->process();

        $this->assertEquals($expected['tasks'], $response);

    }

    public function providerExtraActionException(){
        return Provider::create()
            ->add([
                'file' => 'extra_actions'
            ], 'extra actions')
            ->add([
                'file' => 'extra_actions_single'
            ], 'extra actions single')
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