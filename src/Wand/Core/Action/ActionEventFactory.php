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

use PlanB\Wand\Core\Action\Exception\ActionEventFactoryException;
use PlanB\Wand\Core\Command\Command;
use PlanB\Wand\Core\Command\CommandEvent;
use PlanB\Wand\Core\File\File;
use PlanB\Wand\Core\File\FileEvent;
use PlanB\Wand\Core\Task\Task;
use PlanB\Wand\Core\Task\TaskEvent;

/**
 * Crea objetos ActionEvent.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class ActionEventFactory
{
    /**
     * Crea el objeto ActionEvent que corresponde a un action.
     *
     * @param \PlanB\Wand\Core\Action\ActionInterface $action
     *
     * @return \PlanB\Wand\Core\Action\ActionEvent
     */
    public static function fromAction(ActionInterface $action): ActionEvent
    {
        if ($action instanceof File) {
            $event = new FileEvent($action);
        } elseif ($action instanceof Command) {
            $event = new CommandEvent($action);
        } elseif ($action instanceof Task) {
            $event = new TaskEvent($action);
        } else {
            throw ActionEventFactoryException::create($action);
        }

        return $event;
    }
}
