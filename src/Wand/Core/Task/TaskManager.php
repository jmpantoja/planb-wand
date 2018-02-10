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
     * Añade un conjunto de tareas definidas en un array de configuración
     *
     * @param mixed[] $tasks
     * @return \PlanB\Wand\Core\Task\TaskManager
     */
    public function setTasks(array $tasks): self
    {
        return $this;
    }


    /**
     * Ejecuta una tarea
     *
     * @param string $taskName
     * @param bool $onlyStage
     */
    public function run(string $taskName, bool $onlyStage): void
    {
    }
}
