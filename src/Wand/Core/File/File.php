<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PlanB\Wand\Core\File;

use PlanB\Utils\Path\Path;
use PlanB\Wand\Core\Action\Action;

/**
 * Representa a un fichero del proyecto
 *
 * @package PlanB\Wand\Core\File
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
class File extends Action
{

    public const ACTION_CREATE = 'create';
    public const ACTION_REMOVE = 'remove';

    /**
     * @var int $chmod
     */
    private $chmod;

    /**
     * @var string $action
     */
    private $action;

    /**
     * @var string $template
     */
    private $template;

    /**
     * @var string $target
     */
    private $target;

    /**
     * @var string $group
     */
    private $group;


    /**
     * File constructor.
     *
     * @param mixed[] $params
     */
    private function __construct(array $params)
    {
        $this->action = $params['action'];
        $this->chmod = $params['chmod'];
        $this->template = $params['template'];
        $this->target = $params['target'];
        $this->group = $params['group'];
    }

    /**
     * Crea una nueva instancia
     *
     * @param mixed[] $options
     * @return \PlanB\Wand\Core\File\File
     *
     */
    public static function create(array $options): self
    {
        $params = $options['params'] ?? [];
        $params['group'] = $options['group'];


        $params = FileOptions::create()
            ->resolve($params);

        return new self($params);
    }

    /**
     * Devuelve los permisos del fichero
     *
     * @return int
     */
    public function getChmod(): int
    {
        return $this->chmod;
    }

    /**
     * Devuelve la acción (create|delete)
     *
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * Devuelve la template
     *
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * Devuelve la ruta de destino, (relativa a root_project)
     *
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * Devuelve la ruta absoluta de destino
     *
     * @return string
     */
    public function getPath(): string
    {
        $projectDir = $this->context->getPath('project');

        return Path::join($projectDir, $this->target);
    }

    /**
     * Devuelve las variables necesarias para renderizar el archivo
     *
     * @return string[]
     */
    public function getVars(): array
    {
        return $this->context->getParams();
    }

    /**
     * Indica si el fichero ya existe
     *
     * @return bool
     */
    public function exists(): bool
    {
        $path = $this->getPath();
        $path = Path::create($path);

        return $path->exists();
    }

    /**
     * Devuelve el grupo de acciones a la que pertenece este fichero
     *
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group;
    }
}
