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

use PlanB\Wand\Core\Logger\LogManager;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Modela una tarea
 *
 * @package PlanB\Wand\Core\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
interface TaskInterface
{
    /**
     * Crea una nueva instancia
     *
     * @param mixed[] $params
     * @return \PlanB\Wand\Core\Task\TaskInterface
     */
    public static function create(array $params): TaskInterface;

    /**
     * Asigna un nombre a la tarea
     *
     * @param string $name
     * @return \PlanB\Wand\Core\Task\TaskInterface
     */
    public function setName(string $name): TaskInterface;

    /**
     * Asigna el controlador de eventos
     *
     * @param \Symfony\Component\EventDispatcher\EventDispatcher $dispatcher
     * @return \PlanB\Wand\Core\Task\TaskInterface
     */
    public function setEventDispatcher(EventDispatcher $dispatcher): TaskInterface;


    /**
     * Asigna el gestor de logs
     *
     * @param \PlanB\Wand\Core\Logger\LogManager $logger
     * @return \PlanB\Wand\Core\Task\TaskInterface
     */
    public function setLogger(LogManager $logger): TaskInterface;

    /**
     * Devuelve la descripción de la tarea
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Devuelve las acciones definidas en esta tarea
     *
     * @return \PlanB\Wand\Core\Action\ActionInterface[]
     */
    public function getActions(): array;

    /**
     * Lanza la tarea
     */
    public function launch(): void;
}
