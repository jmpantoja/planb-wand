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
 * Se lanza cuando falla la creación de un ActionEvent.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class ActionEventFactoryException extends \RuntimeException
{
    /**
     * No se puede crear un ActionEvent para un Action.
     *
     * @param \PlanB\Wand\Core\Action\ActionInterface $action
     * @param \Throwable|null                         $previous
     *
     * @return \PlanB\Wand\Core\Action\Exception\ActionEventFactoryException
     */
    public static function create(ActionInterface $action, ?\Throwable $previous = null): self
    {
        $message = sprintf("No es posible crear un evento para la clase '%s' ", get_class($action));

        return new self($message, 0, $previous);
    }
}
