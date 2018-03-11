<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Docs;


use Codeception\Test\Unit;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Utils\Path\Path;
use PlanB\Wand\Composer\Task\ComposerTask;
use PlanB\Wand\Core\Context\Context;
use PlanB\Wand\Core\Git\GitManager;
use PlanB\Wand\Core\Logger\LogManager;
use PlanB\Wand\Core\Logger\Message\LogMessage;
use Mockery as m;
use PlanB\Wand\Docs\Task\SamiTask;
use PlanB\Wand\Git\Task\GitInitTask;

/**
 * Class ComposerTaskTest
 * @package PlanB\Wand\Composer
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass  PlanB\Wand\Docs\Task\SamiTask
 */
class SamiTaskTest extends Unit
{
    use Mocker;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @test
     *
     * @covers ::execute
     * @covers ::getGitManager
     */
    public function testExecute()
    {

        $gitManager = $this->stub(GitManager::class, [
            'isInitialized' => true
        ]);

        $gitManager->allows()
            ->addFilesToStage([realpath('.') . '/docs/api'])
            ->once()
            ->andReturn(true);

        $task = $this->getTask($gitManager);

        $task->allows()
            ->run('sami')
            ->andReturn(LogMessage::success())
            ->once();

        $this->assertTrue($task->execute()->isSuccessful());
    }


    /**
     * @test
     *
     * @covers ::execute
     * @covers ::getGitManager
     */
    public function testExecuteFail()
    {

        $gitManager = $this->stub(GitManager::class, [
            'isInitialized' => true
        ]);

        $gitManager->allows()
            ->addFilesToStage(m::any())
            ->never();

        $task = $this->getTask($gitManager);

        $task->allows()
            ->run('sami')
            ->andReturn(LogMessage::error())
            ->once();

        $this->assertTrue($task->execute()->isError());
    }

    /**
     * @return SamiTask
     */
    protected function getTask($gitManager): SamiTask
    {

        $context = $this->stub(Context::class, [
            'getGitManager' => $gitManager
        ]);

        $context->allows()
            ->getPath('docs_api')
            ->andReturn(realpath('.') . '/docs/api');

        $task = $this->stub(SamiTask::class);
        $task->setContext($context);

        return $task;
    }
}