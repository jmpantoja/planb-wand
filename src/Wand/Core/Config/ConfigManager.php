<?php declare(strict_types=1);

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
use Symfony\Component\Finder\Finder;

/**
 * Gestiona la aplicación "wand"
 * Lee la configuración, crea los objetos action y task
 * y los añade a sus gestores correspondientes.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class ConfigManager
{

    /**
     * @var \PlanB\Wand\Core\Path\PathManager
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
     * Devuelve el array de configuración validado y bien formado.
     *
     * @return mixed[]
     */
    public function getConfig(): array
    {
        $paths = $this->getDefaultPaths();
        $config = DefaultConfig::create(...$paths)
            ->process();

        return $config;
    }

    /**
     * Devuelve la ruta de la configuración por defecto.
     *
     * @return \PlanB\Utils\Path\Path[]
     */
    private function getDefaultPaths(): array
    {
        $paths = [];
        $base = $this->pathManager->wandDir();
        $path = Path::join($base, '/config/default');

        $finder = new Finder();
        $finder->files()
            ->in($path)
            ->name('*.yml');

        foreach ($finder as $file) {
            $paths[] = $file->getPathname();
        }

        return $paths;
    }
}
