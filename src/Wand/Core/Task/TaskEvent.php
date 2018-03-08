<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Wand\Core\Task;

use PlanB\Wand\Core\Action\ActionEvent;
use PlanB\Wand\Core\Logger\Message\LogMessage;

/**
 * Se lanza para ejecutar tareas.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class TaskEvent extends ActionEvent
{
    /**
     * @var \PlanB\Wand\Core\Task\Task
     */
    private $task;

    /**
     * TaskEvent constructor.
     *
     * @param \PlanB\Wand\Core\Task\Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Devuelve la tarea.
     *
     * @return \PlanB\Wand\Core\Task\Task
     */
    public function getTask(): Task
    {
        return $this->task;
    }

    /**
     * Devuelve el nombre del evento.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'wand.task.execute';
    }

    /**
     * Configura el mensaje de log.
     *
     * @param \PlanB\Wand\Core\Logger\Message\LogMessage $message
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function configureLog(LogMessage $message): void
    {
    }
}
