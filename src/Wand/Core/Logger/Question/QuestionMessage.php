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

/**
 * Representa una pregunta que queremos hacer al usuario
 * Vale para solicitar información o para pedir confirmación.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
final class QuestionMessage
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $warning;

    /**
     * @var null|string
     */
    private $default;

    /**
     * @var string[]
     */
    private $options = [];

    /**
     * @var callable
     */
    private $validator;

    /**
     * @var callable
     */
    private $normalizer;

    /**
     * QuestionMessage constructor.
     *
     * @param string $message
     */
    private function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * Crea una nueva instancia.
     *
     * @param string $message
     *
     * @return \PlanB\Wand\Core\Logger\Question\QuestionMessage
     */
    public static function create(string $message): self
    {
        return new self($message);
    }

    /**
     * Devuelve el mensaje.
     *
     * @return string
     */
    public function getMessage(): string
    {
        $text = $this->message;

        if (!empty($this->warning)) {
            $text = sprintf("%s: <fg=yellow>%s</>\n", $this->message, $this->warning);
        }

        return $text;
    }

    /**
     * Asigna el texto de advertencia.
     *
     * @param string $warning
     *
     * @return \PlanB\Wand\Core\Logger\Question\QuestionMessage
     */
    public function setWarning(string $warning): QuestionMessage
    {
        $this->warning = $warning;

        return $this;
    }

    /**
     * Devuelve el valor por defecto.
     *
     * @return null|string
     */
    public function getDefault(): ?string
    {
        if (empty($this->default) && $this->hasOptions()) {
            $this->default = $this->options[0];
        }

        return $this->default;
    }

    /**
     * Asigna el valor por defecto.
     *
     * @param null|string $default
     *
     * @return \PlanB\Wand\Core\Logger\Question\QuestionMessage
     */
    public function setDefault(?string $default): QuestionMessage
    {
        $this->default = $default;

        return $this;
    }

    /**
     * Indica si hay opciones.
     *
     * @return bool
     */
    public function hasOptions(): bool
    {
        return count($this->options) > 0;
    }

    /**
     * Devuelve las opciones válidas para esta question.
     *
     * @return string[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Asigna las opciones para esta question.
     *
     * @param string[] $options
     *
     * @return \PlanB\Wand\Core\Logger\Question\QuestionMessage
     */
    public function setOptions(array $options): QuestionMessage
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Devuelve el validador.
     *
     * @return callable
     */
    public function getValidator(): ?callable
    {
        return $this->validator;
    }

    /**
     * Asigna el validador.
     *
     * @param callable $validator
     *
     * @return \PlanB\Wand\Core\Logger\Question\QuestionMessage
     */
    public function setValidator(callable $validator): QuestionMessage
    {
        $this->validator = $validator;

        return $this;
    }

    /**
     * Devuelve el normalizador.
     *
     * @return callable
     */
    public function getNormalizer(): callable
    {
        return $this->normalizer;
    }

    /**
     * Asigna el normalizador.
     *
     * @param callable $normalizer
     *
     * @return \PlanB\Wand\Core\Logger\Question\QuestionMessage
     */
    public function setNormalizer(callable $normalizer): QuestionMessage
    {
        $this->normalizer = $normalizer;

        return $this;
    }
}
