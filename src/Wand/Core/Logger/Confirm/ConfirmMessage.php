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

/**
 * Representa a una petición de confirmación al usuario.
 *
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class ConfirmMessage
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var bool
     */
    private $default = true;

    /**
     * ConfirmMessage constructor.
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
     * @return \PlanB\Wand\Core\Logger\Confirm\ConfirmMessage
     */
    public static function create(string $message): self
    {
        return new self($message);
    }

    /**
     * Asigna el valor por defecto.
     *
     * @param bool $default
     *
     * @return \PlanB\Wand\Core\Logger\Confirm\ConfirmMessage
     */
    public function setDefault(bool $default): ConfirmMessage
    {
        $this->default = $default;

        return $this;
    }

    /**
     * Devuelve el valor por defecto.
     *
     * @return bool
     */
    public function isTrueByDefault(): bool
    {
        return $this->default;
    }

    /**
     * Devuelve el texto de la pregunta.
     *
     * @return string
     */
    public function getMessage(): string
    {
        $sufix = '(y / N)';
        if ($this->default) {
            $sufix = '(Y / n)';
        }

        return sprintf('%s %s:', $this->message, $sufix);
    }
}
