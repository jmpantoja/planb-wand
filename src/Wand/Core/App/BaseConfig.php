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

use PlanB\Utils\Path\Path;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Yaml;

/**
 * Base para las clases Configuración
 * Contiene lógica y métodos comunes a DefaultConfig y CustomConfig
 *
 * @package PlanB\Wand\Core\App
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
abstract class BaseConfig
{
    /**
     * @var \PlanB\Utils\Path\Path $path
     */
    private $path;

    /**
     * Crea una nueva instancia
     *
     * @param \PlanB\Utils\Path\Path $path
     * @return \PlanB\Wand\Core\App\BaseConfig
     */
    public static function create(Path $path): self
    {
        $className = get_called_class();
        return new $className($path);
    }

    /**
     * BaseConfig constructor.
     *
     * @param \PlanB\Utils\Path\Path $path
     */
    private function __construct(Path $path)
    {
        $this->path = $path;
    }

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    abstract protected function getConfigTree(): TreeBuilder;

    /**
     * Read the config/wand.yml file
     *
     * @return mixed[]
     */
    protected function readFromFile(): array
    {
        return Yaml::parseFile($this->path);
    }

    /**
     * Devuelve la configuración validada y normalizada
     *
     * @return mixed[]
     */
    public function process(): array
    {
        $processor = new Processor();
        $configTree = $this->getConfigTree();
        return $processor->process($configTree->buildTree(), [$this->readFromFile()]);
    }
}
