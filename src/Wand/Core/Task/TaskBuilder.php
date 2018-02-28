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
     * @var mixed[] $tasks
     */
    private $tasks;

    /**
     * @var mixed[] $actions
     */
    private $actions;

    /**
     * TaskBuilder constructor.
     * @param \PlanB\Wand\Core\Context\ContextManager $contextManager
     */
    public function __construct(ContextManager $contextManager)
    {
        $this->contextManager = $contextManager;
    }

    /**
     * Asigna el array de configuración
     *
     * @param mixed[] $config
     * @return \PlanB\Wand\Core\Task\TaskBuilder
     */
    public function setConfig(array $config): self
    {
        $this->tasks = $config['tasks'];
        $this->actions = $config['actions'];

        return $this;
    }


    /**
     * Devuelve una lista de los objetos task definidos
     *
     * @return \PlanB\Wand\Core\Task\TaskInterface[]
     */
    public function getTasks(): array
    {
        $tasks = [];
        foreach ($this->tasks as $name => $options) {
            $tasks[$name] = $this->buildTask($options);
        }

        return $tasks;
    }


    /**
     * Crea una nueva tarea
     *
     * @param mixed[] $options
     *
     * @return \PlanB\Wand\Core\Task\TaskInterface
     */
    private function buildTask(array $options): TaskInterface
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

        array_walk($actions, function (&$action, $name): void {
            $options = $this->actions[$name] ?? [];
            $action = $this->buildAction($options);
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
