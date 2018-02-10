<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\App;

use PlanB\Wand\Core\Path\PathManager;

/**
 * Gestiona la aplicación "wand"
 * Lee la configuración, crea los objetos action y task
 * y los añade a sus gestores correspondientes
 *
 * @package PlanB\Spine\Core\App
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class AppManager
{
    /**
     * @var \PlanB\Wand\Core\Path\PathManager $pathManager
     */
    private $pathManager;

    /**
     * AppManager constructor.
     *
     * @param \PlanB\Wand\Core\Path\PathManager $pathManager
     */
    public function __construct(PathManager $pathManager)
    {
        $this->pathManager = $pathManager;
    }

    /**
     * Construye el proyecto wand para una ruta
     *
     * @param null|string $projectDir
     */
    public function build(?string $projectDir): void
    {
        $this->pathManager->build($projectDir);
    }
}
