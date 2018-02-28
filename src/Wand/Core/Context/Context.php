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

use PlanB\Wand\Core\Context\Exception\UnknowParamException;
use PlanB\Wand\Core\Context\Exception\UnknowPathException;

/**
 * Contexto de la aplicación
 *
 * @package PlanB\Wand\Core\Context
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class Context
{

    /**
     * @var string[] $params
     */
    private $params;

    /**
     * @var string[] $paths
     */
    private $paths;

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
    }

    /**
     * Crea una nueva instancia
     *
     * @param string[] $params
     * @param string[] $paths
     * @return \PlanB\Wand\Core\Context\Context
     */
    public static function create(array $params, array $paths): self
    {
        return new self($params, $paths);
    }

    /**
     * Devuelve una ruta
     *
     * @param string $name
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
     * Devuelve los valores almacenados en composer.json
     *
     * @return string[]
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Devuelve el valor de un parámetro
     *
     * @param string $name
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
}
