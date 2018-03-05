<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Wand\Core\Logger\Question;

use Symfony\Component\EventDispatcher\Event;

/**
 * Evento para pedir información por consola.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class QuestionEvent extends Event
{
    /**
     * @var \PlanB\Wand\Core\Logger\Question\QuestionMessage
     */
    private $question;

    /**
     * @var string
     */
    private $answer;

    /**
     * QuestionEvent constructor.
     *
     * @param \PlanB\Wand\Core\Logger\Question\QuestionMessage $question
     */
    public function __construct(QuestionMessage $question)
    {
        $this->question = $question;
    }

    /**
     * Devuelve el objeto QuestionMessage.
     *
     * @return \PlanB\Wand\Core\Logger\Question\QuestionMessage
     */
    public function getQuestion(): QuestionMessage
    {
        return $this->question;
    }

    /**
     * Devuelve la respuesta dada por el usuario.
     *
     * @return string
     */
    public function getAnswer(): string
    {
        return $this->answer;
    }

    /**
     * Asigna la respuesta dada por el usuario.
     *
     * @param string $answer
     *
     * @return \PlanB\Wand\Core\Logger\Question\QuestionEvent
     */
    public function setAnswer(string $answer): QuestionEvent
    {
        $this->answer = $answer;

        return $this;
    }
}
