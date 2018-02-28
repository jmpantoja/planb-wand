<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Logger;

use PlanB\Wand\Core\Action\ActionEvent;

use PlanB\Wand\Core\Logger\Confirm\ConfirmEvent;
use PlanB\Wand\Core\Logger\Confirm\ConfirmMessage;
use PlanB\Wand\Core\Logger\Message\LogMessage;
use PlanB\Wand\Core\Logger\Message\MessageEvent;
use PlanB\Wand\Core\Logger\Question\QuestionEvent;
use PlanB\Wand\Core\Logger\Question\QuestionMessage;
use PlanB\Wand\Core\Task\TaskInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Gestor de logs
 *
 * @package PlanB\Wand\Core\Logger
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class LogManager
{

    /**
     * @var int $level
     */
    private $level = 0;

    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcher $dispatcher
     */
    private $dispatcher;

    /**
     * LogManager constructor.
     *
     * @param \Symfony\Component\EventDispatcher\EventDispatcher $dispatcher
     */
    public function __construct(EventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function setLevel(int $level): LogManager
    {
        $this->level = $level;
        return $this;
    }

    public function begin(TaskInterface $task): void
    {
        $level = $task->getLevel();

        $title = sprintf("Running %s task...", $task->getName());
        $message = LogMessage::info()
            ->setLevel($level)
            ->setTitle($title);

        $this->message($message);
    }

    /**
     * Muestra un mensaje tipo info por consola
     *
     * @param string $title
     */
    public function info(string $title): void
    {
        $message = LogMessage::info()
            ->setLevel($this->level)
            ->setTitle($title);

        $this->message($message);
    }

    /**
     * Muestra un mensaje tipo success por consola
     *
     * @param string $title
     * @param string[] $verbose
     */
    public function success(string $title, array $verbose = []): void
    {
        $message = LogMessage::success()
            ->setLevel($this->level)
            ->setTitle($title)
            ->setVerbose($verbose);
        $this->message($message);
    }

    /**
     * Muestra un mensaje tipo skip por consola
     *
     * @param string $title
     * @param string[] $verbose
     */
    public function skip(string $title, array $verbose = []): void
    {
        $message = LogMessage::skip()
            ->setLevel($this->level)
            ->setTitle($title)
            ->setVerbose($verbose);

        $this->message($message);
    }

    /**
     * Muestra un mensaje tipo error por consola
     *
     * @param string $title
     * @param string[] $verbose
     */
    public function error(string $title, array $verbose = []): void
    {
        $message = LogMessage::error()
            ->setLevel($this->level)
            ->setTitle($title)
            ->setVerbose($verbose);

        $this->message($message);
    }


    /**
     * Muestra un LogMessage por consola
     *
     * @param \PlanB\Wand\Core\Action\ActionEvent $event
     */
    public function log(ActionEvent $event): void
    {
        $this->message($event->getMessage());
    }

    /**
     * Muestra un LogMessage por consola
     *
     * @param \PlanB\Wand\Core\Logger\Message\LogMessage $message
     */
    public function message(LogMessage $message): void
    {
        $event = new MessageEvent($message);
        $this->dispatcher->dispatch('wand.log.message', $event);
    }


    /**
     * Pide información al usuario
     *
     * @param \PlanB\Wand\Core\Logger\Question\QuestionMessage $question
     * @return string
     */
    public function question(QuestionMessage $question): string
    {
        $event = new QuestionEvent($question);
        $this->dispatcher->dispatch('wand.log.question', $event);

        return $event->getAnswer();
    }

    /**
     * Pide confirmación al usuario
     *
     * @param string $message
     * @param bool $default
     * @return bool
     */
    public function confirm(string $message, bool $default = true): bool
    {
        $question = ConfirmMessage::create($message)
            ->setDefault($default);

        $event = new ConfirmEvent($question);
        $this->dispatcher->dispatch('wand.log.confirm', $event);

        return $event->getAnswer();
    }
}
