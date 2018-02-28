<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\Config;

use PlanB\Utils\Path\Path;
use PlanB\Wand\Core\Path\PathManager;

/**
 * Gestiona la aplicación "wand"
 * Lee la configuración, crea los objetos action y task
 * y los añade a sus gestores correspondientes
 *
 * @package PlanB\Spine\Core\Config
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class ConfigManager
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
     * Devuelve el array de configuración validado y bien formado
     *
     * @return mixed[]
     */
    public function getConfig(): array
    {

        $customPath = $this->getCustomPath();
        $custom = CustomConfig::create($customPath)
            ->process();


        $defaultPath = $this->getDefaultPath();
        $config = DefaultConfig::create($defaultPath)
            ->processWithFilter($custom);
        
        return $config;
    }

    /**
     * Devuelve la ruta de la configuración por defecto
     *
     * @return \PlanB\Utils\Path\Path
     */
    private function getDefaultPath(): Path
    {
        $base = $this->pathManager->wandDir();
        return Path::create($base, 'config/wand.yml');
    }


    /**
     * Devuelve la ruta de la configuración personalizada
     *
     * @return \PlanB\Utils\Path\Path
     */
    private function getCustomPath(): Path
    {
        $base = $this->pathManager->projectDir();
        return Path::create($base, '.wand.yml');
    }
}
