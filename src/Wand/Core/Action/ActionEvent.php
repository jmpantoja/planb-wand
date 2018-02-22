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

use PlanB\Wand\Core\Logger\Message\LogMessage;
use Symfony\Component\EventDispatcher\Event;

/**
 * Evento que se lanza al ejecutar una acción
 *
 * @package PlanB\Wand\Core\Action
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
abstract class ActionEvent extends Event
{
    /**
     * @var \PlanB\Wand\Core\Logger\Message\LogMessage $message
     */
    protected $message;


    /**
     * Devuelve el nombre del evento
     *
     * @return string
     */
    abstract public function getName(): string;

    /**
     * Configura el mensaje de log
     *
     * @param \PlanB\Wand\Core\Logger\Message\LogMessage $message
     */
    abstract public function configureLog(LogMessage $message): void;

    /**
     * Crea un mensaje de log tipo success
     *
     * @return \PlanB\Wand\Core\Action\ActionEvent
     */
    public function success(): self
    {
        $message = LogMessage::success();
        $this->configureLog($message);

        $this->message = $message;
        return $this;
    }


    /**
     * Crea un mensaje de log tipo skip
     *
     * @return \PlanB\Wand\Core\Action\ActionEvent
     */
    public function skip(): self
    {
        $message = LogMessage::skip();
        $this->configureLog($message);

        $this->message = $message;
        return $this;
    }


    /**
     * Crea un mensaje de log tipo error
     *
     * @param null|string $errorMessage
     * @return \PlanB\Wand\Core\Action\ActionEvent
     */
    public function error(?string $errorMessage = null): self
    {
        $message = LogMessage::error();
        $this->configureLog($message);

        if (is_string($errorMessage)) {
            $message->addVerbose('error', $errorMessage);
        }

        $this->message = $message;
        return $this;
    }


    /**
     * Indica que el mensaje NO es de tipo error
     *
     * @return bool
     */
    public function isNotError(): bool
    {
        return !$this->getMessage()->isError();
    }

    /**
     * Devuelve el mensaje de log
     *
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public function getMessage(): LogMessage
    {
        if (empty($this->message)) {
            $this->message = LogMessage::error()
                ->setTitle('No se ha asignado un estado despues de ejecutar la acción');
        }

        return $this->message;
    }
}
