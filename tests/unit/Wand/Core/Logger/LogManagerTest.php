<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Path;

use PlanB\Utils\Dev\Tdd\Test\Data\Data;
use PlanB\Utils\Dev\Tdd\Test\Data\Provider;
use PlanB\Utils\Dev\Tdd\Test\Unit;
use PlanB\Wand\Core\Logger\LogManager;
use PlanB\Wand\Core\Logger\LogMessage;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Class LogManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Logger\LogManager
 */
class LogManagerTest extends Unit
{

    /**
     * @test
     * @dataProvider providerInfo
     *
     * @covers ::setOutput
     * @covers ::info
     * @covers ::success
     * @covers ::skip
     * @covers ::error
     * @covers ::log
     * @covers ::isNormalVerbosity
     */
    public function testLog(Data $data)
    {
        $output = $this->getOutput($data);
        $logger = $this->getLogger($output);

        $method = $data->method;
        $logger->{$method}($data->title, $data->verbose);


        $output->verify('writeln', 1, [$data->output]);
    }

    public function providerInfo()
    {
        $title = 'title';
        $verbose = ['seccion' => 'head'];

        return Provider::create()
            ->add([
                'verbosity' => OutputInterface::VERBOSITY_NORMAL,
                'title' => 'title',
                'verbose' => null,
                'method' => 'info',
                'output' => LogMessage::info('title')->parse()
            ])
            ->add([
                'verbosity' => OutputInterface::VERBOSITY_NORMAL,
                'title' => 'title',
                'verbose' => ['seccion' => 'head'],
                'method' => 'success',
                'output' => LogMessage::success('title')->parse()
            ])
            ->add([
                'verbosity' => OutputInterface::VERBOSITY_VERBOSE,
                'title' => $title,
                'verbose' => $verbose,
                'method' => 'success',
                'output' => LogMessage::success($title, $verbose)->parseVerbose()
            ])
            ->add([
                'verbosity' => OutputInterface::VERBOSITY_NORMAL,
                'title' => $title,
                'verbose' => $verbose,
                'method' => 'skip',
                'output' => LogMessage::skip($title, $verbose)->parse()
            ])
            ->add([
                'verbosity' => OutputInterface::VERBOSITY_VERBOSE,
                'title' => $title,
                'verbose' => $verbose,
                'method' => 'skip',
                'output' => LogMessage::skip($title, $verbose)->parseVerbose()
            ])
            ->add([
                'verbosity' => OutputInterface::VERBOSITY_NORMAL,
                'title' => $title,
                'verbose' => $verbose,
                'method' => 'error',
                'output' => LogMessage::error($title, $verbose)->parseVerbose()
            ])
            ->add([
                'verbosity' => OutputInterface::VERBOSITY_VERBOSE,
                'title' => $title,
                'verbose' => $verbose,
                'method' => 'error',
                'output' => LogMessage::error($title, $verbose)->parseVerbose()
            ])
            ->end();
    }

    /**
     * @param Data $data
     * @return mixed|\PlanB\Utils\Dev\Tdd\Mock\Proxy\ProxyInterface
     */
    protected function getOutput(Data $data)
    {
        $output = $this->mock(OutputInterface::class, [
            'writeln' => null,
            'getVerbosity' => $data->verbosity
        ]);
        return $output;
    }

    /**
     * @param $output
     * @return LogManager
     */
    protected function getLogger($output): LogManager
    {
        $logger = new LogManager();
        $logger->setOutput($output->make());
        return $logger;
    }

}