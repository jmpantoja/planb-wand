<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Action;

use PlanB\Wand\Core\Action\Exception\InvalidActionException;
use PlanB\Wand\Core\File\File;
use PlanB\Wand\Core\Logger\Message\LogMessage;
use Symfony\Component\EventDispatcher\Event;

/**
 * Evento que se lanza al ejecutar una acción
 *
 * @package PlanB\Wand\Core\Action
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class ActionEvent extends Event
{
    /**
     * @var \PlanB\Wand\Core\Action\ActionInterface $action
     */
    private $action;

    /**
     * @var \PlanB\Wand\Core\Logger\Message\LogMessage $message
     */
    private $message;


    /**
     * ActionEvent constructor.
     *
     * @param \PlanB\Wand\Core\Action\ActionInterface|null $action
     */
    public function __construct(?ActionInterface $action = null)
    {
        $this->action = $action;
    }

    /**
     * Devuelve la acción
     *
     * @return \PlanB\Wand\Core\Action\ActionInterface
     */
    public function getAction(): ActionInterface
    {
        return $this->action;
    }


    public function getFile(): File
    {
        if (!$this->action instanceof File) {
            throw InvalidActionException::expectedFile($this->action);
        }

        return $this->action;
    }

    /**
     * Crea un mensaje de log tipo success
     *
     * @param string $title
     * @param string[] $verbose
     *
     * @return \PlanB\Wand\Core\Action\ActionEvent
     */
    public function success(string $title, array $verbose = []): self
    {
        $this->message = LogMessage::success($title, $verbose);
        return $this;
    }


    /**
     * Crea un mensaje de log tipo skip
     *
     * @param string $title
     * @param string[] $verbose
     *
     * @return \PlanB\Wand\Core\Action\ActionEvent
     */
    public function skip(string $title, array $verbose = []): self
    {
        $this->message = LogMessage::skip($title, $verbose);
        return $this;
    }


    /**
     * Crea un mensaje de log tipo error
     *
     * @param string $title
     * @param string[] $verbose
     *
     * @return \PlanB\Wand\Core\Action\ActionEvent
     */
    public function error(string $title, array $verbose = []): self
    {
        $this->message = LogMessage::error($title, $verbose);
        return $this;
    }

    /**
     * Indica que el mensaje NO es de tipo error
     *
     * @return bool
     */
    public function isNotError(): bool
    {
        return !$this->message->isError();
    }

    /**
     * Devuelve el mensaje de log
     *
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public function getMessage(): LogMessage
    {
        return $this->message;
    }
}
