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

use PlanB\Wand\Core\Action\Action;
use PlanB\Wand\Core\Action\ActionEvent;
use PlanB\Wand\Core\Action\ActionEventFactory;
use PlanB\Wand\Core\Action\ActionInterface;
use PlanB\Wand\Core\Context\Context;
use PlanB\Wand\Core\File\File;
use PlanB\Wand\Core\Logger\LogManager;
use PlanB\Wand\Core\Logger\Message\LogMessage;
use PlanB\Wand\Core\Task\Exception\ActionMissingException;
use PlanB\Wand\Core\Task\Exception\InvalidTypeActionException;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Tareas.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
abstract class Task extends Action implements TaskInterface
{
    public const EXIT_SUCCESS = 0;
    public const EXIT_FAIL = 1;

    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected $dispatcher;

    /**
     * @var string
     */
    private $name = '<??>';

    /**
     * @var \PlanB\Wand\Core\Logger\LogManager
     */
    protected $logger;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \PlanB\Wand\Core\Action\ActionInterface[] ;
     */
    private $actions = [];

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
     * {@inheritdoc}
     *
     * @param array $params
     *
     * @return \PlanB\Wand\Core\Task\TaskInterface
     */
    final public static function create(array $params): TaskInterface
    {
        $options = TaskOptions::create()
            ->resolve($params);

        return new static($options);
    }

    /**
     * {@inheritdoc}
     *
     * @param string $name
     *
     * @return \PlanB\Wand\Core\Task\TaskInterface
     */
    public function setName(string $name): TaskInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     *
     * @param \Symfony\Component\EventDispatcher\EventDispatcher $dispatcher
     *
     * @return \PlanB\Wand\Core\Task\TaskInterface
     */
    public function setEventDispatcher(EventDispatcher $dispatcher): TaskInterface
    {
        $this->dispatcher = $dispatcher;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @param \PlanB\Wand\Core\Logger\LogManager $logger
     *
     * @return \PlanB\Wand\Core\Task\TaskInterface
     */
    public function setLogger(LogManager $logger): TaskInterface
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @param \PlanB\Wand\Core\Context\Context $context
     *
     * @return \PlanB\Wand\Core\Action\ActionInterface
     */
    public function setContext(Context $context): ActionInterface
    {
        $this->context = $context;

        foreach ($this->actions as $action) {
            $action->setContext($context);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @param int $level
     *
     * @return \PlanB\Wand\Core\Action\ActionInterface
     */
    public function setLevel(int $level): ActionInterface
    {
        $this->level = $level;

        $this->logger->setLevel($level);
        foreach ($this->actions as $action) {
            $action->setLevel($level);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     *
     * @return \PlanB\Wand\Core\Action\ActionInterface[]
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    /**
     * Indica si una acción está definida.
     *
     * @param string $name
     *
     * @return bool
     */
    public function exists(string $name): bool
    {
        return isset($this->actions[$name]);
    }

    /**
     * Devuelve una acción.
     *
     * @param string $name
     *
     * @return \PlanB\Wand\Core\Action\ActionInterface
     */
    public function get(string $name): ActionInterface
    {
        if (!$this->exists($name)) {
            $availables = array_keys($this->actions);
            throw ActionMissingException::create($name, $availables);
        }

        $action = $this->actions[$name];
        $this->configureActionLevel($action);

        return $action;
    }

    /**
     * Devuelve una acción tipo file.
     *
     * @param string $name
     *
     * @return \PlanB\Wand\Core\File\File
     */
    public function file(string $name): File
    {
        $file = $this->get($name);
        if (!($file instanceof File)) {
            throw InvalidTypeActionException::create($name, File::class);
        }

        return $file;
    }

    /**
     * Asigna el nivel a una acción.
     *
     * @param \PlanB\Wand\Core\Action\ActionInterface $action
     */
    private function configureActionLevel(ActionInterface $action): void
    {
        $level = $this->getLevel();

        if ($action instanceof Task) {
            $level = $this->getLevel() + 1;
        }
        $action->setLevel($level);
    }

    /**
     * Ejecuta una acción.
     *
     * @param string $action
     *
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
     * Ejecuta varias acciones
     *
     * @param string[] ...$actions
     *
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public function sequence(string ...$actions): LogMessage
    {
        $message = LogMessage::success();
        $this->sequenceFrom($message, ...$actions);

        return $message;
    }

    /**
     * Ejecuta varias acciones
     *
     * @param \PlanB\Wand\Core\Logger\Message\LogMessage $message
     * @param string[]                                   ...$actions
     *
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public function sequenceFrom(LogMessage $message, string ...$actions): LogMessage
    {
        foreach ($actions as $action) {
            $temp = $this->run($action);
            $message->mergeType($temp);
        }

        return $message;
    }


    /**
     * Crea un evento para una acción.
     *
     * @param string $name
     *
     * @return \PlanB\Wand\Core\Action\ActionEvent
     */
    private function getEvent(string $name): ActionEvent
    {
        $action = $this->get($name);
        $event = ActionEventFactory::fromAction($action);

        return $event;
    }

    /**
     * {@inheritdoc}
     *
     * @return int
     */
    public function launch(): int
    {
        $this->logger->begin($this);

        $message = $this->execute();

        return $message->getExitCode();
    }

    /**
     * {@inheritdoc}
     */
    abstract public function execute(): LogMessage;
}
