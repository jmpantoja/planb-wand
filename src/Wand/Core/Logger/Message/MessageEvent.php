<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Logger\Message;

use Symfony\Component\EventDispatcher\Event;

/**
 * Evento lanzado para mostrar un mensaje por consola
 *
 * @package PlanB\Wand\Core\Logger\Message
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class MessageEvent extends Event
{
    /**
     * @var \PlanB\Wand\Core\Logger\Message\LogMessage $message
     */
    private $message;

    /**
     * QuestionEvent constructor.
     *
     * @param \PlanB\Wand\Core\Logger\Message\LogMessage $message
     */
    public function __construct(LogMessage $message)
    {
        $this->message = $message;
    }

    /**
     * Devuelve el objeto LogMessage
     *
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public function getMessage(): LogMessage
    {
        return $this->message;
    }
}
