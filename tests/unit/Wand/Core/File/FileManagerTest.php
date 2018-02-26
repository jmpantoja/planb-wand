<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\File;

use Codeception\Test\Unit;
use Mockery as m;
use PlanB\Utils\Dev\Tdd\Feature\Mocker;
use PlanB\Wand\Core\Context\ContextManager;
use PlanB\Wand\Core\Logger\Message\LogMessage;
use PlanB\Wand\Core\Logger\Message\MessageType;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class TaskManagerTest
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\File\FileManager
 */
class FileManagerTest extends Unit
{

    use Mocker;

    /**
     * @var  \UnitTester $tester
     */
    protected $tester;

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::create
     */
    public function testCreateSkip()
    {

        $event = $this->getEvent('create', true);

        $manager = $this->stub(FileManager::class);
        $manager->create($event);

        $this->assertMessage('Create file TARGET', MessageType::SKIP(), $event->getMessage());
    }


    protected function assertMessage(string $text, MessageType $type, LogMessage $message)
    {
        $lines = $message->parseVerbose();
        $this->tester->assertContains($text, $lines[0]);
        $this->tester->assertTrue($message->getType()->is($type));
    }

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::create
     * @covers ::dumpFile
     */
    public function testCreateSuccess()
    {

        $fileSystem = $this->stub(Filesystem::class);

        $fileSystem->expects()
            ->dumpFile('/path/to/TARGET', m::any())
            ->once()
            ->andReturn(null);

        $fileSystem->expects()
            ->chmod('/path/to/TARGET', m::any(), m::any(), m::any())
            ->once()
            ->andReturn(null);

        $event = $this->getEvent('create', false);

        $manager = $this->getFileManager();
        $manager->create($event);

        $this->assertMessage('Create file TARGET', MessageType::SUCCESS(), $event->getMessage());

    }

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::create
     * @covers ::dumpFile
     */
    public function testCreateFail()
    {

        $fileSystem = $this->stub(Filesystem::class);

        $fileSystem->allows()
            ->dumpFile(m::any(), m::any())
            ->once()
            ->andReturnUsing(function () {
                throw new \Exception('fallo al crear el archivo');
            });

        $fileSystem->expects()
            ->chmod(m::any(), m::any(), m::any(), m::any())
            ->never();

        $event = $this->getEvent('create', false);
        $manager = $this->getFileManager();
        $manager->create($event);

        $this->assertMessage('Create file TARGET', MessageType::ERROR(), $event->getMessage());

    }

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::remove
     * @covers ::deleteFile
     */
    public function testRemoveSkip()
    {

        $this->stub(Filesystem::class)
            ->expects()
            ->remove(m::any())
            ->never();

        $event = $this->getEvent('remove', false);
        $manager = $this->getFileManager();
        $manager->remove($event);

        $this->assertMessage('Remove file TARGET', MessageType::SKIP(), $event->getMessage());
    }

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::remove
     * @covers ::deleteFile
     */
    public function testRemoveSuccess()
    {

        $this->stub(Filesystem::class)
            ->expects()
            ->remove(m::any())
            ->once();

        $event = $this->getEvent('remove', true);
        $manager = $this->getFileManager();
        $manager->remove($event);

        $this->assertMessage('Remove file TARGET', MessageType::SUCCESS(), $event->getMessage());

    }


    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::remove
     * @covers ::deleteFile
     */
    public function testRemoveFail()
    {

        $fileSystem = $this->stub(Filesystem::class);

        $fileSystem->allows()
            ->remove(m::any())
            ->andReturnUsing(function () {
                throw new \Exception('Fallo al borrar el archivo');
            });

        $event = $this->getEvent('remove', true);
        $manager = $this->getFileManager();
        $manager->remove($event);

        $this->assertMessage('Remove file TARGET', MessageType::ERROR(), $event->getMessage());


    }

    public function testSubscribedEvents()
    {
        $this->tester->assertEquals([
            'wand.file.create' => 'create',
            'wand.file.remove' => 'remove',
        ], FileManager::getSubscribedEvents());
    }


    protected function getEvent(string $action, $exists)
    {
        $file = $this->stub(File::class, [
            'exists' => $exists,
            'getTarget' => 'TARGET',
            'getPath' => '/path/to/TARGET',
            'getTemplate' => 'template',
            'getAction' => $action,
            'getChmod' => 0644,
            'getVars' => []
        ]);

        return new FileEvent($file);
    }

    protected function getFileManager()
    {
        $twig = $this->stub(\Twig_Environment::class, [
            'render' => 'content'
        ]);
        $context = $this->stub(ContextManager::class, [
            'toArray' => []
        ]);

        return new FileManager($twig, $context);
    }


}