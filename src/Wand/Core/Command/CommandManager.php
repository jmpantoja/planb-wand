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

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Gestiona los comandos
 *
 * @package PlanB\Wand\Core\Command
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class CommandManager implements EventSubscriberInterface
{

    /**
     * @inheritdoc
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            'wand.cmd.execute' => 'execute',
        ];
    }

    /**
     * Ejecuta el comando
     *
     * @param \PlanB\Wand\Core\Command\CommandEvent $event
     */
    public function execute(CommandEvent $event): void
    {
        $command = $event->getCommand();

        if ($command->run()) {
            $event->success();
        } else {
            $event->error();
        }
    }
}