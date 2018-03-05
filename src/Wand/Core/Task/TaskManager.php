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
use PlanB\Wand\Core\Context\Context;
use PlanB\Wand\Core\Context\ContextManager;
use PlanB\Wand\Core\Task\Exception\TaskMissingException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Gestiona las tareas.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class TaskManager implements EventSubscriberInterface
{
    /**
     * @var \PlanB\Wand\Core\Context\ContextManager
     */
    private $contextManager;

    /**
     * @var \PlanB\Wand\Core\Context\Context
     */
    private $context;

    /**
     * @var \PlanB\Wand\Core\Task\TaskInterface[]
     */
    private $tasks;

    /**
     * {@inheritdoc}
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            'wand.task.execute' => 'execute',
        ];
    }

    /**
     * TaskManager constructor.
     *
     * @param \PlanB\Wand\Core\Config\ConfigManager $configManager
     * @param \PlanB\Wand\Core\Context\ContextManager $contextManager
     * @param \PlanB\Wand\Core\Task\TaskBuilder $builder
     */
    public function __construct(ConfigManager $configManager, ContextManager $contextManager, TaskBuilder $builder)
    {
        $this->contextManager = $contextManager;

        $config = $configManager->getConfig();
        $builder->setConfig($config);

        $this->setTasks($builder->getTasks());
    }

    /**
     * Añade un conjunto de tareas definidas en un array de configuración.
     *
     * @param mixed[] $tasks
     *
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
     * Añade una tarea al stack.
     *
     * @param string $name
     * @param \PlanB\Wand\Core\Task\TaskInterface $task
     *
     * @return \PlanB\Wand\Core\Task\TaskManager
     */
    public function addTask(string $name, TaskInterface $task): self
    {
        $this->tasks[$name] = $task;

        return $this;
    }

    /**
     * Indica si la tarea está definida.
     *
     * @param string $task
     *
     * @return bool
     */
    public function exists(string $task): bool
    {
        return isset($this->tasks[$task]);
    }

    /**
     * Devuelve una tarea.
     *
     * @param string $name
     *
     * @return \PlanB\Wand\Core\Task\TaskInterface
     */
    public function get(string $name): TaskInterface
    {
        if (!$this->exists($name)) {
            $availables = array_keys($this->tasks);
            throw TaskMissingException::create($name, $availables);
        }

        $task = $this->tasks[$name];
        $task->setContext($this->getContext());

        return $this->tasks[$name];
    }

    /**
     * Devuelve el objeto contexto.
     *
     * @return \PlanB\Wand\Core\Context\Context
     */
    private function getContext(): Context
    {
        if (is_null($this->context)) {
            $this->context = $this->contextManager->getContext();
        }

        return $this->context;
    }

    /**
     * Ejecuta una tarea definida por su nombre.
     *
     * @param string $name
     * @return int
     */
    public function executeByName(string $name): int
    {
        $task = $this->get($name);
        $event = new TaskEvent($task);

        return $this->execute($event);
    }

    /**
     * Ejecuta una tarea
     *
     * @param \PlanB\Wand\Core\Task\TaskEvent $event
     * @return int
     */
    public function execute(TaskEvent $event): int
    {
        $task = $event->getTask();
        $exitCode = $task->launch();

        $event->blank();

        return $exitCode;
    }
}
