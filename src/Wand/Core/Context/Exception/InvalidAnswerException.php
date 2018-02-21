<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Context\Exception;

use RuntimeException;
use Throwable;

/**
 * El valor introducido por el usuario no es correcto
 *
 * @package PlanB\Wand\Core\Context\Exception
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class InvalidAnswerException extends RuntimeException
{
    /**
     * Parámetro requerido
     *
     * @param \Throwable $previous
     * @return \PlanB\Wand\Core\Context\Exception\InvalidAnswerException
     */
    public static function required(?Throwable $previous = null): self
    {
        return new self("El parámetro solicitado es requerido", 0, $previous);
    }

    /**
     * El valor dado no está entre las opciones
     *
     * @param mixed $answer
     * @param string[] $options
     * @param \Throwable $previous
     * @return \PlanB\Wand\Core\Context\Exception\InvalidAnswerException
     */
    public static function notInOptions($answer, array $options, ?Throwable $previous = null): self
    {
        $values = implode('|', $options);
        $message = sprintf("El valor '%s' no está entre los esperados (%s)", $answer, $values);

        return new self($message, 0, $previous);
    }

    /**
     * Error personalizado
     *
     * @param string $message
     * @param \Throwable $previous
     * @return \PlanB\Wand\Core\Context\Exception\InvalidAnswerException
     */
    public static function custom(string $message, ?Throwable $previous = null): self
    {
        return new self($message, 0, $previous);
    }
}
