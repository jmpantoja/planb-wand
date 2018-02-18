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
use PlanB\Wand\Core\Task\Exception\ActionMissingException;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Tareas
 *
 * @package PlanB\Wand\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
abstract class Task implements TaskInterface
{
    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcher $dispatcher
     */
    protected $dispatcher;

    /**
     * @var \PlanB\Wand\Core\Logger\LogManager $logger
     */
    private $logger;

    /**
     * @var string $description
     */
    private $description;

    /**
     * @var \PlanB\Wand\Core\Action\ActionInterface[] $actions ;
     */
    private $actions;

    /**
     * Task constructor.
     *
     * @param mixed[] $options
     */
    final public function __construct(array $options)
    {
        $this->description = $options['description'];
        $this->actions = $options['actions'];
    }

    /**
     * @inheritdoc
     *
     * @param array $params
     * @return \PlanB\Wand\Core\Task\TaskInterface
     */
    final public static function create(array $params): TaskInterface
    {
        $options = TaskOptions::create()
            ->resolve($params);

        return new static($options);
    }


    /**
     * @inheritdoc
     *
     * @param \Symfony\Component\EventDispatcher\EventDispatcher $dispatcher
     * @return \PlanB\Wand\Core\Task\TaskInterface
     */
    public function setEventDispatcher(EventDispatcher $dispatcher): TaskInterface
    {
        $this->dispatcher = $dispatcher;
        return $this;
    }

    /**
     * @inheritdoc
     *
     * @param \PlanB\Wand\Core\Logger\LogManager $logger
     * @return \PlanB\Wand\Core\Task\TaskInterface
     */
    public function setLogger(LogManager $logger): TaskInterface
    {

        $this->logger = $logger;
        return $this;
    }


    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @inheritdoc
     *
     * @return \PlanB\Wand\Core\Action\ActionInterface[]
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    /**
     * Indica si una acción está definida
     *
     * @param string $name
     * @return bool
     */
    public function exists(string $name): bool
    {
        return isset($this->actions[$name]);
    }

    /**
     * Devuelve una acción
     *
     * @param string $name
     * @return \PlanB\Wand\Core\Action\ActionInterface
     */
    public function get(string $name): ActionInterface
    {
        if (!$this->exists($name)) {
            $availables = array_keys($this->actions);
            throw ActionMissingException::create($name, $availables);
        }

        return $this->actions[$name];
    }

    /**
     * Ejecuta una acción
     *
     * @param string $action
     */
    public function run(string $action): void
    {
        $action = $this->get($action);
        $name = $action->getEventName();

        $event = new GenericEvent($action);
        $this->dispatcher->dispatch($name, $event);
    }

    /**
     * Lanza la tarea
     */
    public function launch(string $name): void
    {
        $title = sprintf('Running %s task...', $name);
        $this->logger->info($title);
        $this->execute();
    }

    /**
     * @inheritdoc
     */
    abstract public function execute(): void;
}
