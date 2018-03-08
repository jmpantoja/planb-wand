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
use PlanB\Utils\Dev\Tdd\Data\Data;
use PlanB\Utils\Dev\Tdd\Data\Provider;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Utils\Path\Path;
use PlanB\Wand\Core\Context\Context;
use Symfony\Component\Process\Process;
use Mockery as m;

/**
 * Class CommandText
 * @package PlanB\Wand\Core\Command
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass  \PlanB\Wand\Core\Command\SystemCommand
 */
class SystemCommandTest extends Unit
{
    use Mocker;

    /**
     * @var \UnitTester
     */
    protected $tester;


    /**
     * @test
     *
     *
     * @covers \PlanB\Wand\Core\Command\Command::__construct
     *
     * @covers ::__construct
     * @covers ::create
     * @covers ::getTitle
     * @covers ::getCwd
     * @covers ::getGroup
     */
    public function testCreate()
    {
        $command = $this->getCommmand();

        $base = realpath('.');
        $this->tester->assertEquals('Group', $command->getGroup());

        $cwd = sprintf('%s/vendor/bin', $base);
        $this->tester->assertEquals($cwd, $command->getCwd());
    }


    /**
     * @test
     *
     *
     * @covers \PlanB\Wand\Core\Command\Command::__construct
     * @covers \PlanB\Wand\Core\Command\Command::getCommandLine
     * @covers \PlanB\Wand\Core\Command\Command::getCommandTokens
     *
     * @covers ::getCommandLine
     *
     */
    public function testCommandLine()
    {


        $command = $this->getCommmand();

        $base = realpath('.');
        $commandLine = sprintf('%s/vendor/bin/ls -la %s', $base, $base);
        $this->tester->assertEquals($commandLine, $command->getCommandLine());

        $this->tester->assertEquals([
            sprintf('%s/vendor/bin/ls', realpath('.')),
            '-la',
            realpath('.'),

        ], $command->getCommandTokens());

    }


    /**
     * @test
     * @dataProvider providerTitle
     *
     * @covers       \PlanB\Wand\Core\Command\Command::__construct
     * @covers       \PlanB\Wand\Core\Command\Command::getDefaultTitle
     * @covers       \PlanB\Wand\Core\Command\Command::getTitle
     *
     * @covers ::getCommandLine
     *
     */
    public function testTitle(Data $data)
    {
        $context = $this->stub(Context::class);
        $context->allows()
            ->getPath(m::notAnyOf('vendor/bin'))
            ->andReturn(realpath('.'));

        $context->allows()
            ->getPath('vendor/bin')
            ->andReturn(realpath('.') . '/vendor/bin');

        $command = SystemCommand::create([
            'group' => 'group',
            'params' => [
                'pattern' => 'command -la %target%',
                'cwd' => $data->cwd,
                'title' => $data->title,
            ]
        ]);

        $command->setContext($context);

        $this->tester->assertEquals($data->expected, $command->getTitle());

    }

    public function providerTitle()
    {
        return Provider::create()
            ->add([
                'cwd' => 'vendor/bin',
                'expected' => 'vendor/bin/command',
                'title' => null
            ])
            ->add([
                'cwd' => null,
                'expected' => 'command',
                'title' => null
            ])
            ->add([
                'cwd' => 'vendor/bin',
                'expected' => 'overwrite',
                'title' => 'overwrite'
            ])
            ->add([
                'cwd' => null,
                'expected' => 'overwrite',
                'title' => 'overwrite'
            ])
            ->end();
    }


    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::create
     *
     * @covers ::getCwd
     */
    public function testCwd()
    {
        $context = $this->stub(Context::class);
        $context->allows()
            ->getPath('vendor/bin')
            ->andReturn(Path::join(realpath('.'), 'vendor/bin'));

        $command = SystemCommand::create([
            'group' => 'group',
            'params' => [
                'pattern' => 'ls -la %target%',
                'cwd' => 'vendor/bin'
            ]
        ]);
        $command->setContext($context);

        $this->assertEquals(sprintf('%s/vendor/bin', realpath('.')), $command->getCwd());


        $command = SystemCommand::create([
            'group' => 'group',
            'params' => [
                'pattern' => 'ls -la %target%'
            ]
        ]);

        $this->assertNull($command->getCwd());
    }


    /**
     * @test
     *
     * @covers ::execute
     * @covers ::run
     *
     * @covers ::getModifiedFiles
     * @covers ::parseModifiedFiles
     * @covers ::isRunnable
     *
     * @covers ::isSuccessful
     * @covers ::buildOutput
     * @covers ::getSuccessOutput
     * @covers ::getOutput
     */
    public function testRunSkip()
    {
        $command = $this->getCommmand(true);

        $this->assertTrue($command->execute()->isSkipped());
        $this->assertEquals('No se ha modificado nigún archivo desde la última ejecución', $command->getOutput());
    }

    /**
     * @test
     *
     * @covers ::execute
     * @covers ::run
     *
     * @covers ::getModifiedFiles
     * @covers ::parseModifiedFiles
     * @covers ::isRunnable
     *
     * @covers ::isSuccessful
     * @covers ::buildOutput
     * @covers ::getSuccessOutput
     * @covers ::getOutput
     */
    public function testRunSuccess()
    {
        $process = $this->stub(Process::class, [
            'isSuccessful' => true,
            'getOutput' => 'output'
        ]);

        $process->expects()
            ->getErrorOutput()
            ->never();


        $command = $this->getCommmand();
        $this->assertTrue($command->execute()->isSuccessful());

        $this->assertEquals('output', $command->getOutput());
    }


    /**
     * @test
     *
     * @covers ::execute
     * @covers ::run
     *
     * @covers ::getModifiedFiles
     * @covers ::parseModifiedFiles
     * @covers ::isRunnable
     *
     * @covers ::isSuccessful
     * @covers ::buildOutput
     * @covers ::getErrorOutput
     * @covers ::getOutput
     */
    public function testRunFail()
    {
        $process = $this->stub(Process::class, [
            'isSuccessful' => false,
            'getErrorOutput' => 'output'
        ]);

        $process->expects()
            ->getOutput()
            ->never();


        $command = $this->getCommmand();
        $command->run();

        $this->assertTrue($command->execute()->isError());

        $this->assertEquals('output', $command->getOutput());
    }

    /**
     * @test
     *
     * @covers ::run
     * @covers ::isSuccessful
     * @covers ::buildOutput
     * @covers ::getErrorOutput
     * @covers ::getOutput
     */
    public function testRunFailEmptyOutput()
    {
        $process = $this->stub(Process::class, [
            'isSuccessful' => false,
            'getErrorOutput' => ''
        ]);

        $process->expects()
            ->getOutput()
            ->once()
            ->andReturn('output');


        $command = $this->getCommmand();
        $command->run();

        $this->assertEquals('output', $command->getOutput());
    }


    /**
     * @return Command
     */
    protected function getCommmand(bool $onlyModified = false, array $files = []): Command
    {
        $context = $this->stub(Context::class, [
            'getModifiedFiles' => $files
        ]);
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


        $command = SystemCommand::create([
            'group' => 'group',
            'params' => [
                'pattern' => 'ls -la %target%',
                'cwd' => 'vendor/bin',
                'only_modified' => $onlyModified
            ]
        ]);

        $command->setContext($context);
        return $command;
    }
}