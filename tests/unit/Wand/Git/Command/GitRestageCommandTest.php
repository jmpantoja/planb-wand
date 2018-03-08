<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Git\Command;


use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\Context\Context;
use PlanB\Wand\Core\Git\GitManager;

/**
 * Class GitRestageCommandTest
 * @package PlanB\Wand\Git\Command
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Git\Command\GitRestageCommand
 */
class GitRestageCommandTest extends Unit
{
    use Mocker;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @test
     *
     * @covers  ::run
     * @covers  ::getGitManager
     * @covers  ::getCommandLine
     */
    public function testRun()
    {

        $gitManager = $this->stub(GitManager::class, [
            'getStagedFiles' => [
                'src/FileA.php',
                'src/FileB.php',
                'src/FileC.php',
            ]
        ]);

        $gitManager->allows()
            ->reStageFiles()
            ->once()
            ->andReturn(true);

        $command = $this->getCommand($gitManager);

        $this->assertTrue($command->run());

        $this->assertEquals('git add src/FileA.php src/FileB.php src/FileC.php', $command->getCommandLine());
    }

    private function getCommand($gitManager)
    {

        $context = $this->stub(Context::class, [
            'getGitManager' => $gitManager
        ]);

        $context->allows()
            ->getPath('src')
            ->andReturn(realpath('.'));

        $command = $this->stub(GitRestageCommand::class);
        $command->setContext($context);

        return $command;
    }

}