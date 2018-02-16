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

class File extends Action
{
    /**
     * File constructor.
     *
     * @param mixed[] $options
     */
    private function __construct(array $options)
    {
        //codecept_debug($options);
    }

    /**
     * Crea una nueva instancia
     *
     * @param mixed[] $options
     * @return \PlanB\Wand\Core\Action\File
     *
     */
    public static function create(array $options): self
    {
        return new self($options);
    }
}
