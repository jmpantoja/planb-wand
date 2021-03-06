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

use PlanB\Wand\Core\Logger\Message\LogMessage;

/**
 * Tareas.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class SimpleTask extends Task
{
    /**
     * Ejecuta la tarea.
     *
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public function execute(): LogMessage
    {
        $actions = array_keys($this->getActions());

        return $this->sequence(...$actions);
    }
}
