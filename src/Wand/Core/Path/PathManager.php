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
     * Configura todas las rutas desde la ruta del proyecto
     * Si la ruta no contiene un archivo composer.json, lo busca en los padres
     * Si no lo encuentra, o no existe lanza una excepción
     *
     * @param string $projectDir
     */
    public function build(string $projectDir): void
    {
        if (!file_exists($projectDir)) {
            throw InvalidProjectDirectoryException::notFound($projectDir);
        }

        $this->projectDir = $this->findProjectDir($projectDir);
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
}
