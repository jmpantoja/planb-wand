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

use PlanB\Wand\Core\Action\ActionInterface;
use PlanB\Wand\Core\Context\ContextManager;

/**
 * Se encarga de instancias tareas
 *
 * @package PlanB\Wand\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class TaskBuilder
{

    /**
     * @var \PlanB\Wand\Core\Context\ContextManager $contextManager
     */
    private $contextManager;

    /**
     * TaskBuilder constructor.
     * @param \PlanB\Wand\Core\Context\ContextManager $contextManager
     */
    public function __construct(ContextManager $contextManager)
    {
        $this->contextManager = $contextManager;
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
        $className = $options['classname'];
        unset($options['classname']);

        $options['actions'] = $this->resolveActions($options);

        return $className::create($options);
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

        array_walk($actions, function (&$action): void {
            $action = $this->buildAction($action);
        });

        return $actions;
    }

    /**
     * Crea una nueva acción
     *
     * @param mixed[] $options
     * @return \PlanB\Wand\Core\Action\ActionInterface
     */
    private function buildAction(array $options): ActionInterface
    {
        $className = $options['classname'];
        unset($options['classname']);

        $context = $this->contextManager->getContext();

        $action = $className::create($options);
        $action->setContext($context);

        return $action;
    }
}
