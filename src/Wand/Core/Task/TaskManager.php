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

use PlanB\Wand\Core\Path\PathManager;

/**
 * Gestiona las tareas
 *
 * @package PlanB\Wand\Task
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class TaskManager
{

    /**
     * @var \PlanB\Wand\Core\Path\PathManager $pathManager
     */
    private $pathManager;

    /**
     * TaskManager constructor.
     *
     * @param \PlanB\Wand\Core\Path\PathManager $pathManager
     */
    public function __construct(PathManager $pathManager)
    {
        $this->pathManager = $pathManager;
    }

    /**
     * Ejecuta una tarea
     *
     * @param string $taskName
     * @param bool $onlyStage
     */
    public function runTask(string $taskName, ?string $projectDir, bool $onlyStage): void
    {
        $this->configure($projectDir, $onlyStage);
    }

    /**
     * Configura el gestor de tareas
     *
     * @param null|string $projectDir
     * @param bool $onlyStage
     */
    private function configure(?string $projectDir, bool $onlyStage): void
    {
        $this->pathManager->build($projectDir);
    }
}
