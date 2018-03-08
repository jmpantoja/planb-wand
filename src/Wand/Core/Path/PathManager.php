<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Wand\Core\Path;

use PlanB\Utils\Path\Path;
use PlanB\Utils\Path\PathTree;
use PlanB\Wand\Core\Path\Exception\InvalidProjectDirectoryException;

/**
 * Gestiona las rutas utiles para la aplicacion.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class PathManager
{
    /**
     * @var string
     */
    private $projectDir;

    /**
     * @var string
     */
    private $targetPath;

    /**
     * PathManager constructor.
     */
    public function __construct()
    {
        $this->build(null);
    }

    /**
     * Configura todas las rutas desde la ruta del proyecto
     * Si la ruta no contiene un archivo composer.json, lo busca en los padres
     * Si no lo encuentra, o no existe lanza una excepción.
     *
     * @param null|string $projectDir
     */
    public function build(?string $projectDir): void
    {
        $projectDir = $this->sanitizePathArgument($projectDir);

        $this->targetPath = $projectDir;
        $this->projectDir = $this->findProjectDir($projectDir);
    }

    /**
     * Devuelve el argumento path bien formado.
     *
     * @param string $projectDir
     *
     * @return null|string
     */
    private function sanitizePathArgument(?string $projectDir): string
    {
        $path = $projectDir ?? realpath('.');
        $realPath = realpath($path);

        if (empty($realPath)) {
            throw InvalidProjectDirectoryException::notFound($path);
        }

        return (string) $realPath;
    }

    /**
     * Localiza el directorio del proyecto
     * Busca un fichero composer.json en el projectDir o en sus padres, hasta encontralo.
     *
     * @param string $projectDir
     *
     * @return string
     */
    protected function findProjectDir(string $projectDir): string
    {
        $tree = PathTree::create($projectDir)
            ->getInversedPathTree();

        $projectPath = null;
        foreach ($tree as $path) {
            $composer = $path->append('composer.json');
            if ($composer->isFile()) {
                $projectPath = $path;
                break;
            }
        }

        if (is_null($projectPath)) {
            throw InvalidProjectDirectoryException::composerMissing($projectDir);
        }

        return (string) $projectPath;
    }

    /**
     * Devuelve la ruta del proyecto.
     *
     * @return string
     */
    public function projectDir(): string
    {
        return $this->projectDir;
    }

    /**
     * Devuelve la ruta indicada como argumento.
     *
     * @return string
     */
    public function targetPath(): string
    {
        return $this->targetPath;
    }

    /**
     * Devuelve la ruta del archivo composer.json.
     *
     * @return string
     */
    public function composerJsonPath(): string
    {
        return Path::join($this->projectDir, 'composer.json');
    }

    /**
     * Devuelve la ruta del proyecto wand.
     *
     * @return string
     */
    public function wandDir(): string
    {
        $wandDir = Path::create(__DIR__)
            ->parent(4);

        return $wandDir;
    }

    /**
     * Devuelve un array con todas las rutas.
     *
     * @return string[]
     */
    public function getPaths(): array
    {
        return [
            'project' => $this->projectDir(),
            'src' => Path::join($this->projectDir(), 'src'),
            'vendor' => Path::join($this->projectDir(), 'vendor'),
            'vendor/bin' => Path::join($this->projectDir(), 'vendor/bin'),
            'wand-vendor/bin' => Path::join($this->wandDir(), 'vendor/bin'),
            'wand-bin' => Path::join($this->wandDir(), 'bin'),
            'target' => $this->targetPath(),
            'composer' => $this->composerJsonPath(),
            'wand' => $this->wandDir(),
        ];
    }
}
