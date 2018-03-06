<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Tdd\Command;


use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Data\Data;
use PlanB\Utils\Dev\Tdd\Data\Provider;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\File\File;
use Mockery as m;
use PlanB\Wand\Core\Logger\LogManager;
use PlanB\Wand\Core\Logger\Message\LogMessage;
use Symfony\Component\Process\Process;

/**
 * Class CodeceptTaskTest
 * @package PlanB\Wand\Tdd\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Tdd\Command\CoverageCommand
 */
class CoverageCommandTest extends Unit
{

    use Mocker;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @test
     *
     * @dataProvider providerSuccessful
     *
     * @covers ::isSuccessful
     * @covers ::findCoverage
     */
    public function testSuccessful(Data $data)
    {
        $process = $this->stub(Process::class, [
            'isSuccessful' => $data->successful
        ]);

        $lines = $data->lines;
        $methods = $data->methods;
        $classes = $data->classes;

        $command = $this->stub(CoverageCommand::class, [
            'getOutput' => "bla bla bla\n" .
                "Summary:\n" .
                "Classes: $classes% (1/2) \n" .
                "Methods: $methods% (1/2) \n" .
                "Lines: $lines% (1/2) \n" .
                "bla bla bla"
        ]);

        $this->assertEquals($data->expected, $command->isSuccessful($process));

    }

    public function providerSuccessful()
    {
        return Provider::create()
            ->add([
                'lines' => 81,
                'methods' => 81,
                'classes' => 81,
                'successful' => true,
                'expected' => true
            ])
            ->add([
                'lines' => 80,
                'methods' => 80,
                'classes' => 80,
                'successful' => true,
                'expected' => true
            ])
            ->add([
                'lines' => 79,
                'methods' => 100,
                'classes' => 100,
                'successful' => true,
                'expected' => false
            ])
            ->add([
                'lines' => 100,
                'methods' => 79,
                'classes' => 100,
                'successful' => true,
                'expected' => false
            ])
            ->add([
                'lines' => 100,
                'methods' => 100,
                'classes' => 79,
                'successful' => true,
                'expected' => false
            ])
            ->add([
                'lines' => 100,
                'methods' => 100,
                'classes' => 100,
                'successful' => false,
                'expected' => false
            ])
            ->end();
    }
}