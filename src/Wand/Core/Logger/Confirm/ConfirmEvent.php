<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Wand\Core\Logger\Confirm;

use Symfony\Component\EventDispatcher\Event;

/**
 * Evento para pedir confirmación por consola.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class ConfirmEvent extends Event
{
    /**
     * @var \PlanB\Wand\Core\Logger\Confirm\ConfirmMessage
     */
    private $confirm;

    /**
     * @var bool
     */
    private $answer;

    /**
     * QuestionEvent constructor.
     *
     * @param \PlanB\Wand\Core\Logger\Confirm\ConfirmMessage $confirm
     */
    public function __construct(ConfirmMessage $confirm)
    {
        $this->confirm = $confirm;
    }

    /**
     * Devuelve el objeto ConfirmMessage.
     *
     * @return \PlanB\Wand\Core\Logger\Confirm\ConfirmMessage
     */
    public function getConfirm(): ConfirmMessage
    {
        return $this->confirm;
    }

    /**
     * Indica si el usuario ha elegido la opción SI
     *
     * @return bool
     */
    public function isTrue(): bool
    {
        return $this->answer;
    }

    /**
     * Indica si el usuario ha elegido la opción NO
     *
     * @return bool
     */
    public function isFalse(): bool
    {
        return !$this->answer;
    }


    /**
     * Asigna la respuesta dada por el usuario.
     *
     * @param bool $answer
     *
     * @return \PlanB\Wand\Core\Logger\Confirm\ConfirmEvent
     */
    public function setAnswer(bool $answer): ConfirmEvent
    {
        $this->answer = $answer;
        return $this;
    }
}
