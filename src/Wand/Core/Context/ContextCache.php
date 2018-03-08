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
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Gestiona el fichero de cache de wand
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
final class ContextCache
{

    /**
     * @var \PlanB\Utils\Path\Path
     */
    private $path;

    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    private $fileSystem;

    /**
     * @var int[]
     */
    private $data;


    /**
     * @var int[]
     */
    private $temp = [];

    /**
     * ContextCache constructor.
     *
     * @param \PlanB\Utils\Path\Path $path
     */
    private function __construct(Path $path)
    {
        $this->path = $path;
        $this->fileSystem = new Filesystem();
        $this->data = $this->read();
    }

    /**
     * Crea una nueva instancia
     *
     * @param string $projectPath
     *
     * @return \PlanB\Wand\Core\Context\ContextCache
     */
    public static function create(string $projectPath): self
    {
        $path = Path::create($projectPath, '.wand-cache');

        return new self($path);
    }

    /**
     * Indica si un fichero ha sido modificado, o no
     *
     * @param \Symfony\Component\Finder\SplFileInfo $fileInfo
     *
     * @return bool
     */
    public function filter(SplFileInfo $fileInfo): bool
    {
        $path = $fileInfo->getPathname();
        $this->temp[$path] = $fileInfo->getMTime();

        $lastExecution = $this->getLastExecution($path);

        return $fileInfo->getMTime() > $lastExecution;
    }


    /**
     * Devuelve el timestamp de la última ejecución
     *
     * @param string $path
     *
     * @return int
     */
    private function getLastExecution(string $path): int
    {
        return $this->data[$path] ?? 0;
    }


    /**
     * Lee el contenido del fichero de cache
     *
     * @return mixed[]
     */
    private function read(): array
    {

        if ($this->path->isFile()) {
            $contents = file_get_contents($this->path);
            $data = json_decode($contents, 1);
        } else {
            $data = [];
        }

        return $data;
    }

    /**
     * Actualiza el timestamp de la última ejecución de cada archivo
     */
    public function update(): void
    {
        $this->data = array_replace($this->data, $this->temp);
        $this->fileSystem->dumpFile($this->path, json_encode($this->data, JSON_PRETTY_PRINT));
    }
}
