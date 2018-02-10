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
 * Se encarga de instancias tareas
 *
 * @package PlanB\Wand\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
final class TaskBuilder
{

    /**
     * TaskBuilder constructor.
     */
    private function __construct()
    {
    }

    /**
     * Crea una nueva instancia
     *
     * @return \PlanB\Wand\Core\Task\TaskBuilder
     */
    public static function create(): self
    {
        return new self();
    }

    /**
     * Crea una nueva tarea
     *
     * @param mixed[] $options
     *
     * @return \PlanB\Wand\Core\Task\TaskInterface
     */
    public function buildTask(array $options): TaskInterface
    {
        $className = $this->getClassName($options);
        unset($options['classname']);

        $options['actions'] = $this->resolveActions($options);

        return $className::create($options);
    }

    /**
     * Devuelve el nombre de la clase
     *
     * @param mixed[] $options
     * @return string
     */
    private function getClassName(array $options): string
    {
        $className = $options['classname'] ?? Task::class;

        return (string)$className;
    }

    /**
     * Resuelve la lista de acciones de una tarea
     *
     * @param mixed[] $options
     * @return \PlanB\Wand\Core\Task\Action[]
     */
    private function resolveActions(array $options): array
    {
        $actions = $options['actions'] ?? [];
        return $actions;
    }
}
