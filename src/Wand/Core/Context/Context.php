<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Wand\Core\Context;

use PlanB\Utils\Path\Path;
use PlanB\Wand\Core\Context\Exception\UnknowParamException;
use PlanB\Wand\Core\Context\Exception\UnknowPathException;
use PlanB\Wand\Core\Git\GitManager;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

/**
 * Contexto de la aplicación.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class Context
{
    /**
     * @var string[]
     */
    private $params;

    /**
     * @var string[]
     */
    private $paths = [];

    /**
     * @var \PlanB\Wand\Core\Git\GitManager
     */
    private $gitManager;

    /**
     * @var \PlanB\Wand\Core\Context\ContextCache
     */
    private $cache;

    /**
     * Context constructor.
     *
     * @param string[] $params
     * @param string[] $paths
     */
    private function __construct(array $params, array $paths)
    {
        $this->params = $params;
        $this->paths = $paths;

        $base = $this->getPath('project');
        $this->gitManager = GitManager::create($base);

        $this->cache = ContextCache::create($base);
    }

    /**
     * Crea una nueva instancia.
     *
     * @param string[] $params
     * @param string[] $paths
     *
     * @return \PlanB\Wand\Core\Context\Context
     */
    public static function create(array $params, array $paths): self
    {
        return new self($params, $paths);
    }

    /**
     * Devuelve una ruta.
     *
     * @param string $name
     *
     * @return mixed|string
     */
    public function getPath(string $name)
    {
        if (!isset($this->paths[$name])) {
            $availables = array_keys($this->paths);
            throw  UnknowPathException::create($name, $availables);
        }

        return $this->paths[$name];
    }

    /**
     * Devuelve una ruta, relativa a una de las rutas del contexto
     *
     * @param string $path
     * @param string $base
     *
     * @return string
     */
    public function getPathRelativeTo(string $path, string $base = 'project'): string
    {
        $fileSystem = new Filesystem();
        $base = $this->getPath($base);

        $relative = $fileSystem->makePathRelative($path, $base);

        return Path::normalize($relative);
    }

    /**
     * Devuelve los archivos php modificados en una ruta
     *
     * @param string $name
     *
     * @return string[]
     */
    public function getModifiedFiles(string $name): array
    {

        $files = [];
        $path = $this->getPath($name);

        $finder = new Finder();
        $finder->in($path)->name('*.php');

        foreach ($finder as $fileInfo) {
            if (!$this->cache->filter($fileInfo)) {
                continue;
            }

            $files[] = $this->getPathRelativeTo($fileInfo->getPathname());
        }

        return $files;
    }


    /**
     * Actualiza el timestamp de última ejecución
     */
    public function updateLastExecution(): void
    {
        $this->cache->update();
    }

    /**
     * Devuelve los valores almacenados en composer.json.
     *
     * @return string[]
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Devuelve el valor de un parámetro.
     *
     * @param string $name
     *
     * @return string
     */
    public function getParam(string $name): string
    {
        if (!isset($this->params[$name])) {
            $availables = array_keys($this->params);
            throw  UnknowParamException::create($name, $availables);
        }

        return $this->params[$name];
    }

    /**
     * Devuelve el gestor de Git
     *
     * @return \PlanB\Wand\Core\Git\GitManager
     */
    public function getGitManager(): GitManager
    {
        $files = $this->getModifiedFiles('src');


        $this->gitManager->setWhiteList($files);

        return $this->gitManager;
    }
}
