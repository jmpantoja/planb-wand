<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Command;

use PlanB\Wand\Core\Action\Action;

class Command extends Action
{
    /**
     * Crea una nueva instancia
     *
     * @param mixed[] $options
     * @return \PlanB\Wand\Core\Command\Command
     */
    public static function create(array $options): self
    {
        return new self($options);
    }
}
