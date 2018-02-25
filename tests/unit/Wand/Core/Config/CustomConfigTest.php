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

use PlanB\Utils\Path\Path;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;
use Symfony\Component\Yaml\Yaml;

/**
 * Class CustomConfigTest
 * @package PlanB\Wand\Core\Config
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Config\CustomConfig
 */
class CustomConfigTest extends Unit
{


    use Mocker;

    /**
     * @var  \UnitTester $tester
     */
    protected $tester;

    /**
     * @test
     * @dataProvider providerProcess
     *
     * @covers ::getConfigTree
     * @covers ::defineTasks
     *
     * @covers       \PlanB\Wand\Core\Config\BaseConfig::__construct
     * @covers       \PlanB\Wand\Core\Config\BaseConfig::create
     * @covers       \PlanB\Wand\Core\Config\BaseConfig::process
     * @covers       \PlanB\Wand\Core\Config\BaseConfig::readFromFile
     */
    public function testProcess(Data $data)
    {
        $data->expectException($data->exception, function (Data $data) {
            $path = $data->path;
            $expected = $data->expected;

            $config = CustomConfig::create($path)
                ->process();

            $this->tester->assertEquals($expected, $config);
        }, $this->tester);
    }

    public function providerProcess()
    {
        return Provider::create()
            ->add([
                'path' => Path::create(sprintf('%s/configs/custom/valid.yml', __DIR__)),
                'expected' => $this->fromFile('valid.expected'),
                'exception' => null
            ], 'valid')
            ->add([
                'path' => Path::create(sprintf('%s/configs/custom/default_values.yml', __DIR__)),
                'expected' => $this->fromFile('default_values.expected'),
                'exception' => null
            ], 'default values')
            ->add([
                'path' => Path::create(sprintf('%s/configs/custom/invalid.yml', __DIR__)),
                'expected' => null,
                'exception' => InvalidTypeException::class
            ], 'default values')
            ->end();
    }


    private function fromFile(string $name): array
    {
        $data = [];
        $path = sprintf('%s/configs/custom/%s.yml', __DIR__, $name);
        if (is_file($path)) {
            $data = Yaml::parseFile($path);
        }

        return $data;

    }

}