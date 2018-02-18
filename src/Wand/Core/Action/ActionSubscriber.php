<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Action;

use PlanB\Wand\Core\File\FileManager;
use PlanB\Wand\Core\Logger\LogManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Escucha los distintos eventos de ejecución de acciones
 *
 * @package PlanB\Wand\Core\Action
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class ActionSubscriber implements EventSubscriberInterface
{

    /**
     * @var \PlanB\Wand\Core\File\FileManager $fileManager
     */
    private $fileManager;

    /**
     * @var \PlanB\Wand\Core\Logger\LogManager $logger
     */
    private $logger;


    public function __construct(FileManager $fileManager, LogManager $logger)
    {
        $this->fileManager = $fileManager;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            'wand.file.execute' => 'file',
        ];
    }

    public function file(GenericEvent $event): void
    {
        $message = $this->fileManager->execute($event->getSubject());
        $this->logger->log($message);
    }
}
