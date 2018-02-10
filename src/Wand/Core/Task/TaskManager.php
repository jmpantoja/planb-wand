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
 * Gestiona las tareas
 *
 * @package PlanB\Wand\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class TaskManager
{
    
    /**
     * Ejecuta una tarea
     *
     * @param string $taskName
     * @param bool $onlyStage
     */
    public function run(string $taskName, bool $onlyStage): void
    {
        echo "ejecutar $taskName en modo $onlyStage";
    }
}
