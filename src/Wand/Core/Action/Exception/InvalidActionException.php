<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Action\Exception;

use PlanB\Wand\Core\Action\ActionInterface;

/**
 * Se lanza cuando un ActionEvent no devuelve una acción del tipo esperado
 *
 * @package PlanB\Wand\Core\Action\Exception
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class InvalidActionException extends \RuntimeException
{

    /**
     * Se esperaba un File, pero devuelve otra cosa
     *
     * @param \PlanB\Wand\Core\Action\ActionInterface $action
     * @param \Throwable $previous
     * @return \PlanB\Wand\Core\Action\Exception\InvalidActionException
     */
    public static function expectedFile(ActionInterface $action, ?\Throwable $previous = null): self
    {
        $message = sprintf('la acción es de tipo %s, y se esperaba un File', get_class($action));

        return new self($message, 0, $previous);
    }
}
