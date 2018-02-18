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
use PlanB\Wand\Core\Action\ActionSubscriber;
use PlanB\Wand\Core\Logger\LogManager;
use PlanB\Wand\Core\Logger\LogMessage;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Class ActionSubscriberTest
 *
 * @package PlanB\Spine\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * @coversDefaultClass \PlanB\Wand\Core\Action\ActionSubscriber
 */
class ActionSubscriberTest extends Unit
{

    /**
     * @test
     *
     * @covers ::__construct
     * @covers ::getSubscribedEvents
     * @covers ::file
     */
    public function testFile()
    {
        $fileManager = $this->mock(FileManager::class, [
            'execute' => $this->make(LogMessage::class)
        ]);

        $logger = $this->mock(LogManager::class, [
            'log' => null
        ]);

        $subscriber = new ActionSubscriber(
            $fileManager->make(),
            $logger->make()
        );

        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber($subscriber);

        $event = new GenericEvent($this->make(File::class));

        $dispatcher->dispatch('wand.file.execute', $event);

        $fileManager->verify('execute', 1);


    }

}