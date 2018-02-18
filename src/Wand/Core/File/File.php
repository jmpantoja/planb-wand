<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\File;

use PlanB\Wand\Core\Action\ActionInterface;

class File implements ActionInterface
{
    /**
     * File constructor.
     *
     * @param mixed[] $options
     */
    private function __construct(array $options)
    {
    }

    /**
     * Crea una nueva instancia
     *
     * @param mixed[] $options
     * @return \PlanB\Wand\Core\File\File
     *
     */
    public static function create(array $options): self
    {
        return new self($options);
    }

    /**
     * Devuelve el nombre del evento asociado a esta acción
     *
     * @return string
     */
    public function getEventName(): string
    {
        return 'wand.file.execute';
    }
}
