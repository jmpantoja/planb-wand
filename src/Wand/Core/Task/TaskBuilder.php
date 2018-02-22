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
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Se encarga de instancias tareas
 *
 * @package PlanB\Wand\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class TaskBuilder implements ContainerAwareInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    private $container;

    /**
     * TaskBuilder constructor.
     *
     * TaskBuilder constructor.
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
    }


    public function setContainer(?ContainerInterface $container = null): void
    {
        $this->container = $container;
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

        $action = $className::create($options);
        $action->setContainer($this->container);

        return $action;
    }
}
