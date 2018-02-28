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
     * @var mixed[] $configs
     */
    private $config = [
        'tasks' => [],
        'actions' => [],
    ];


    /**
     * Crea una nueva instancia
     *
     * @param \PlanB\Utils\Path\Path[] ...$path
     * @return \PlanB\Wand\Core\Config\BaseConfig
     */
    public static function create(Path ...$path): self
    {
        return new static(...$path);
    }

    /**
     * BaseConfig constructor.
     *
     * @param \PlanB\Utils\Path\Path[] ...$paths
     */
    private function __construct(Path ...$paths)
    {
        foreach ($paths as $path) {
            $config = $this->readFromFile($path);
            $tasks = $config['tasks'] ?? [];
            $actions = $config['actions'] ?? [];

            $this->config['tasks'] = array_merge($this->config['tasks'], $tasks);
            $this->config['actions'] = array_merge($this->config['actions'], $actions);
        }

        $this->config = array_filter($this->config);
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
     * @param \PlanB\Utils\Path\Path $path
     * @return mixed[]
     */
    protected function readFromFile(Path $path): array
    {
        return Yaml::parseFile($path);
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
        return $processor->process($configTree->buildTree(), [$this->config]);
    }
}
