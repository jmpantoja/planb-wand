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

use PlanB\Wand\Core\Config\ConfigManager;
use PlanB\Wand\Core\Task\Exception\TaskMissingException;

/**
 * Gestiona las tareas
 *
 * @package PlanB\Wand\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class TaskManager
{
    /**
     * @var \PlanB\Wand\Core\Task\TaskInterface[] $tasks
     */
    private $tasks;


    /**
     * @var \PlanB\Wand\Core\Config\ConfigManager $configManager
     */
    private $configManager;


    /**
     * TaskManager constructor.
     *
     * @param \PlanB\Wand\Core\Config\ConfigManager $configManager
     * @param \PlanB\Wand\Core\Task\TaskBuilder $builder
     */
    public function __construct(ConfigManager $configManager, TaskBuilder $builder)
    {
        $this->configManager = $configManager;
        $config = $this->configManager->getConfig();

        $builder->setConfig($config);

        $this->setTasks($builder->getTasks());
    }

    /**
     * Añade un conjunto de tareas definidas en un array de configuración
     *
     * @param mixed[] $tasks
     * @return \PlanB\Wand\Core\Task\TaskManager
     */
    public function setTasks(array $tasks): self
    {
        foreach ($tasks as $name => $task) {
            $this->addTask($name, $task);
        }
        return $this;
    }

    /**
     * Añade una tarea al stack
     *
     * @param string $name
     * @param \PlanB\Wand\Core\Task\TaskInterface $task
     * @return \PlanB\Wand\Core\Task\TaskManager
     */
    public function addTask(string $name, TaskInterface $task): self
    {
        $this->tasks[$name] = $task;
        return $this;
    }

    /**
     * Indica si la tarea está definida
     *
     * @param string $task
     * @return bool
     */
    public function exists(string $task): bool
    {
        return isset($this->tasks[$task]);
    }

    /**
     * Devuelve una tarea
     *
     * @param string $task
     * @return \PlanB\Wand\Core\Task\TaskInterface
     */
    public function get(string $task): TaskInterface
    {

        if (!$this->exists($task)) {
            $availables = array_keys($this->tasks);
            throw TaskMissingException::create($task, $availables);
        }

        return $this->tasks[$task];
    }
}
