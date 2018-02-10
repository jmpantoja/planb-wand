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
 * Gestiona las rutas utiles para la aplicacion
 *
 * @package PlanB\Wand\Core\Path
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class PathManager
{

    /**
     * @var string $projectDir
     */
    private $projectDir;

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
     * Si no lo encuentra, o no existe lanza una excepción
     *
     * @param null|string $projectDir
     */
    public function build(?string $projectDir): void
    {
        $projectDir = $this->sanitizePathArgument($projectDir);
        $this->projectDir = $this->findProjectDir($projectDir);
    }


    /**
     * Devuelve el argumento path bien formado
     *
     * @param string $projectDir
     * @return null|string
     */
    private function sanitizePathArgument(?string $projectDir): string
    {
        $path = $projectDir ?? realpath('.');
        $realPath = realpath($path);

        if (empty($realPath)) {
            throw InvalidProjectDirectoryException::notFound($path);
        }

        return (string)$realPath;
    }


    /**
     * Localiza el directorio del proyecto
     * Busca un fichero composer.json en el projectDir o en sus padres, hasta encontralo
     *
     *
     * @param string $projectDir
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

        if (empty($projectPath)) {
            throw InvalidProjectDirectoryException::composerMissing($projectDir);
        }

        return (string)$projectPath;
    }

    /**
     * Devuelve la ruta del proyecto
     *
     * @return string
     */
    public function projectDir(): string
    {
        return $this->projectDir;
    }

    /**
     * Devuelve la ruta del proyecto wand
     *
     * @return string
     */
    public function wandDir(): string
    {
        return Path::create(__DIR__)
            ->parent(4);
    }
}
