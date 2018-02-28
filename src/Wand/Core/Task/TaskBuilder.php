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
use PlanB\Wand\Core\Logger\LogManager;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Se encarga de instancias tareas
 *
 * @package PlanB\Wand\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class TaskBuilder
{
    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcher $dispatcher
     */
    private $dispatcher;

    /**
     * @var \PlanB\Wand\Core\Logger\LogManager $logger
     */
    private $logger;

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
     *
     * @param \Symfony\Component\EventDispatcher\EventDispatcher $dispatcher
     * @param \PlanB\Wand\Core\Logger\LogManager $logger
     */
    public function __construct(EventDispatcher $dispatcher, LogManager $logger)
    {
        $this->dispatcher = $dispatcher;
        $this->logger = $logger;
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
            $tasks[$name] = $this->buildTask($name, $options);
        }

        return $tasks;
    }


    /**
     * Crea una nueva tarea
     *
     * @param string $name
     * @param mixed[] $options
     *
     * @return \PlanB\Wand\Core\Task\TaskInterface
     */
    private function buildTask(string $name, array $options): TaskInterface
    {
        $className = $options['classname'];
        unset($options['classname']);

        $options['actions'] = $this->resolveActions($options);

        $task = $className::create($options);

        $task->setName($name);
        $task->setEventDispatcher($this->dispatcher);
        $task->setLogger($this->logger);

        return $task;
    }


    /**
     * Resuelve la lista de acciones de una tarea
     *
     * @param mixed[] $options
     * @return \PlanB\Wand\Core\Action\ActionInterface[]
     */
    private function resolveActions(array $options): array
    {
        $actions = $options['actions'] ?? [];

        array_walk($actions, function (&$action, $name): void {

            $ref = $this->getTaskRef($name);

            if (is_null($ref)) {
                $options = $this->actions[$name] ?? [];
                $action = $this->buildAction($options);
            } else {
                $options = $this->tasks[$ref] ?? [];
                $action = $this->buildTask($ref, $options);
            }
        });

        return $actions;
    }

    /**
     * Devuelve null si es el nombre de una acción, o el nombre de una tarea
     *
     * @param string $name
     * @return string
     */
    private function getTaskRef(string $name): ?string
    {
        $matches = [];
        if (preg_match('/^@(.*)/', $name, $matches)) {
            return $matches[1];
        }

        return null;
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
        return $action;
    }
}
