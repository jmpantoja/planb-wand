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

use PlanB\Utils\Dev\Tdd\Test\Unit;
use PlanB\Wand\Core\Context\ContextManager;
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

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::create
     */
    public function testCreateSkip()
    {

        $twig = $this->make(\Twig_Environment::class);
        $context = $this->make(ContextManager::class);

        $file = $this->make(File::class, [
            'exists' => true,
            'getTarget' => 'TARGET',
            'getPath' => '/path/to/TARGET',
            'getAction' => 'create'
        ]);

        $event = new FileEvent($file);
        $manager = new FileManager($twig, $context);
        $manager->create($event);

        $this->assertTrue($event->getMessage()->isSkipped());
    }

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::create
     * @covers ::dumpFile
     */
    public function testCreate()
    {

        $fileSystem = $this->mock(Filesystem::class, [
            'dumpFile' => null,
            'chmod' => null
        ]);

        $twig = $this->make(\Twig_Environment::class, [
            'render' => 'content'
        ]);
        $context = $this->make(ContextManager::class, [
            'toArray' => []
        ]);

        $file = $this->make(File::class, [
            'exists' => false,
            'getTarget' => 'TARGET',
            'getPath' => '/path/to/TARGET',
            'getAction' => 'create',
            'getTemplate' => 'template',
            'getChmod' => 0644
        ]);

        $event = new FileEvent($file);
        $manager = new FileManager($twig, $context);
        $manager->create($event);

        $this->assertTrue($event->getMessage()->isSuccessful());

        $fileSystem->verify('dumpFile', 1, ['/path/to/TARGET']);
        $fileSystem->verify('chmod', 1, ['/path/to/TARGET']);
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

        $fileSystem = $this->mock(Filesystem::class, [
            'dumpFile' => function () {
                throw new \Exception('fallo al crear el archivo');
            },
            'chmod' => null
        ]);

        $twig = $this->make(\Twig_Environment::class, [
            'render' => 'content'
        ]);
        $context = $this->make(ContextManager::class, [
            'toArray' => []
        ]);

        $file = $this->make(File::class, [
            'exists' => false,
            'getTarget' => 'TARGET',
            'getPath' => '/path/to/TARGET',
            'getAction' => 'create',
            'getTemplate' => 'template',
            'getChmod' => 0644
        ]);

        $event = new FileEvent($file);
        $manager = new FileManager($twig, $context);
        $manager->create($event);

        $this->assertTrue($event->getMessage()->isError());

        $fileSystem->verify('dumpFile', 0, ['/path/to/TARGET']);
        $fileSystem->verify('chmod', 0, ['/path/to/TARGET']);
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

        $fileSystem = $this->mock(Filesystem::class);
        $twig = $this->make(\Twig_Environment::class);
        $context = $this->make(ContextManager::class);

        $file = $this->make(File::class, [
            'exists' => false,
            'getTarget' => 'TARGET',
            'getPath' => '/path/to/TARGET',
            'getAction' => 'create',
        ]);

        $event = new FileEvent($file);
        $manager = new FileManager($twig, $context);
        $manager->remove($event);

        $this->assertTrue($event->getMessage()->isSkipped());

        $fileSystem->verify('remove', 0);

    }

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::remove
     * @covers ::deleteFile
     */
    public function testRemove()
    {

        $fileSystem = $this->mock(Filesystem::class, [
            'remove' => null
        ]);

        $twig = $this->make(\Twig_Environment::class);

        $context = $this->make(ContextManager::class);

        $file = $this->make(File::class, [
            'exists' => true,
            'getTarget' => 'TARGET',
            'getPath' => '/path/to/TARGET',
            'getAction' => 'create',
        ]);

        $event = new FileEvent($file);
        $manager = new FileManager($twig, $context);
        $manager->remove($event);

        $this->assertTrue($event->getMessage()->isSuccessful());

        $fileSystem->verify('remove', 1, ['/path/to/TARGET']);
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

        $fileSystem = $this->mock(Filesystem::class, [
            'remove' => function () {
                throw new \Exception('Fallo al borrar el archivo');
            }
        ]);

        $twig = $this->make(\Twig_Environment::class);

        $context = $this->make(ContextManager::class);

        $file = $this->make(File::class, [
            'exists' => true,
            'getTarget' => 'TARGET',
            'getPath' => '/path/to/TARGET',
            'getAction' => 'create',
        ]);

        $event = new FileEvent($file);
        $manager = new FileManager($twig, $context);
        $manager->remove($event);

        $this->assertTrue($event->getMessage()->isError());

        $fileSystem->verify('remove', 0, ['/path/to/TARGET']);
    }

    public function testSubscribedEvents()
    {
        $this->assertEquals([
            'wand.file.create' => 'create',
            'wand.file.remove' => 'remove',
        ], FileManager::getSubscribedEvents());
    }
}