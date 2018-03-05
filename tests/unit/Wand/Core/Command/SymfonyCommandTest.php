<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Command;


use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Utils\Path\Path;
use PlanB\Wand\Core\Context\Context;
use PlanB\Wand\Legacy\Phpcpd\PhpcpdCommand;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Class CommandText
 * @package PlanB\Wand\Core\Command
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass  \PlanB\Wand\Core\Command\SymfonyCommand
 */
class SymfonyCommandTest extends Unit
{
    use Mocker;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::create
     * @covers ::getCommand
     */
    public function testCreate()
    {
        $command = $this->getCommmand();

        $this->tester->assertInstanceOf(SymfonyCommand::class, $command);
        $this->tester->assertInstanceOf(PhpcpdCommand::class, $command->getCommand());

    }


    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::run
     */
    public function testRun()
    {
        $this->stub(BufferedOutput::class, [
            'fetch' => 'output'
        ]);

        $this->double(PhpcpdCommand::class, [
            'run' => 0
        ]);

        $command = $this->getCommmand();

        $this->assertTrue($command->run());

        $this->assertEquals('output', $command->getOutput());
    }


    /**
     * @return Command
     */
    protected function getCommmand(): Command
    {
        $context = $this->stub(Context::class);
        $context->allows()
            ->getPath('vendor/bin')
            ->andReturn(Path::join(realpath('.'), 'vendor/bin'));

        $context->allows()
            ->getPath('project')
            ->andReturn(realpath('.'));

        $context->allows()
            ->getPath('target')
            ->andReturn(realpath('.'));

        $context->allows()
            ->getPath('wand')
            ->andReturn(realpath('.'));

        $context->allows()
            ->getPath('src')
            ->andReturn(Path::join(realpath('.'), 'src'));


        $command = SymfonyCommand::create([
            'group' => 'group',
            'params' => [
                'pattern' => 'phpcpd --min-tokens 30 %src%',
                'command' => PhpcpdCommand::class
            ]
        ]);

        $command->setContext($context);
        return $command;
    }

}