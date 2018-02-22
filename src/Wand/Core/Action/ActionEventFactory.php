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

use PlanB\Wand\Core\Action\Exception\ActionEventFactoryException;
use PlanB\Wand\Core\File\File;
use PlanB\Wand\Core\File\FileEvent;

/**
 * Crea objetos ActionEvent
 *
 * @package PlanB\Wand\Core\Action
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class ActionEventFactory
{
    /**
     * Crea el objeto ActionEvent que corresponde a un action
     *
     * @param \PlanB\Wand\Core\Action\ActionInterface $action
     * @return \PlanB\Wand\Core\Action\ActionEvent
     */
    public static function fromAction(ActionInterface $action): ActionEvent
    {
        if (!($action instanceof File)) {
            throw ActionEventFactoryException::create($action);
        }

        $event = new FileEvent($action);

        return $event;
    }
}
