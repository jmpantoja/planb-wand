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

/**
 * Tareas
 *
 * @package PlanB\Wand\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class SimpleTask extends Task
{

    /**
     * Ejecuta la tarea
     */
    public function execute(): void
    {
        $actions = array_keys($this->getActions());

        foreach ($actions as $action) {
            $this->run($action);
        }
    }
}
