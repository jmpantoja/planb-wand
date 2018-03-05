<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Wand\Core\Task;

use PlanB\Wand\Core\Action\ActionInterface;
use PlanB\Wand\Core\Logger\LogManager;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Modela una tarea.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
interface TaskInterface extends ActionInterface
{
    /**
     * Crea una nueva instancia.
     *
     * @param mixed[] $params
     *
     * @return \PlanB\Wand\Core\Task\TaskInterface
     */
    public static function create(array $params): TaskInterface;

    /**
     * Asigna el controlador de eventos.
     *
     * @param \Symfony\Component\EventDispatcher\EventDispatcher $dispatcher
     *
     * @return \PlanB\Wand\Core\Task\TaskInterface
     */
    public function setEventDispatcher(EventDispatcher $dispatcher): TaskInterface;

    /**
     * Asigna el gestor de logs.
     *
     * @param \PlanB\Wand\Core\Logger\LogManager $logger
     *
     * @return \PlanB\Wand\Core\Task\TaskInterface
     */
    public function setLogger(LogManager $logger): TaskInterface;

    /**
     * Devuelve el nivel de esta acción.
     *
     * @return int
     */
    public function getLevel(): int;

    /**
     * Devuelve el nombre de la tarea.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Devuelve la descripción de la tarea.
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Devuelve las acciones definidas en esta tarea.
     *
     * @return \PlanB\Wand\Core\Action\ActionInterface[]
     */
    public function getActions(): array;

    /**
     * Lanza la tarea.
     *
     * @return \PlanB\Wand\Core\Logger\Message\LogMessage
     */
    public function launch(): void;
}
