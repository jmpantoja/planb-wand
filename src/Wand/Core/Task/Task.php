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

use PlanB\Wand\Core\Action\ActionEvent;
use PlanB\Wand\Core\Action\ActionEventFactory;
use PlanB\Wand\Core\Action\ActionInterface;
use PlanB\Wand\Core\Logger\LogManager;
use PlanB\Wand\Core\Logger\Message\LogMessage;
use PlanB\Wand\Core\Task\Exception\ActionMissingException;
use Symfony\Component\EventDispatcher\EventDispatcher;

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
     * @var string $name
     */
    private $name = '<??>';

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
     * @param string $name
     * @return \PlanB\Wand\Core\Task\TaskInterface
     */
    public function setName(string $name): TaskInterface
    {
        $this->name = $name;
        return $this;
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
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public function run(string $action): LogMessage
    {
        $event = $this->getEvent($action);
        $name = $event->getName();

        $this->dispatcher->dispatch($name, $event);

        $this->logger->log($event);
        return $event->getMessage();
    }

    /**
     * Crea un evento para una acción
     *
     * @param string $name
     * @return \PlanB\Wand\Core\Action\ActionEvent
     */
    private function getEvent(string $name): ActionEvent
    {
        $action = $this->get($name);
        $event = ActionEventFactory::fromAction($action);

        return $event;
    }

    /**
     * Lanza la tarea
     */
    public function launch(): void
    {
        $this->validateContext();

        $title = sprintf('Running %s task...', $this->name);
        $this->logger->info($title);
        $this->execute();
    }

    /**
     * Comprueba que los valores del composer.json sean correctos
     * antes de ejecutar la tarea
     *
     */
    protected function validateContext(): void
    {
        $this->dispatcher->dispatch('wand.context.execute');
    }

    /**
     * @inheritdoc
     */
    abstract public function execute(): void;
}
