<?php
/**
 * This file is part of the planb project.
 *
 * (c) Jose Manuel Pantoja <jmpantoja@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PlanB\Wand\Core\Command;

use PlanB\Wand\Core\Action\Action;

/**
 * Modela un commando.
 *
 * @author Jose Manuel Pantoja <jmpantoja@gmail.com>
 */
abstract class Command extends Action
{
    /**
     * @var string
     */
    private $group;

    /**
     * @var string
     */
    private $pattern;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string ;
     */
    protected $output = '';

    /**
     * Command constructor.
     *
     * @param mixed[] $params
     */
    protected function __construct(array $params)
    {
        $this->group = (string)$params['group'];
        $this->pattern = (string)$params['pattern'];
        $this->title = (string)$params['title'];
    }

    /**
     * Crea una nueva instancia.
     *
     * @param mixed[] $options
     *
     * @return \PlanB\Wand\Core\Command\Command
     */
    public static function create(array $options): self
    {
        $params = $options['params'] ?? [];
        $params['group'] = $options['group'];

        $params = CommandOptions::create()
            ->resolve($params);

        return new static($params);
    }

    /**
     * Devuelve el comando a ejecutar.
     *
     * @return string
     */
    public function getCommandLine(): string
    {
        $commandLine = $this->pattern;

        $replacements = [
            '%project%' => $this->context->getPath('project'),
            '%target%' => $this->context->getPath('target'),
            '%src%' => $this->context->getPath('src'),
            '%wand%' => $this->context->getPath('wand'),
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $commandLine);
    }

    /**
     * Devuelve la linea de comandos, separada en tokens
     *
     * @return string[]
     */
    public function getCommandTokens(): array
    {
        return explode(' ', $this->getCommandLine());
    }

    /**
     * Devuelve el titulo del mensaje de log
     *
     * @return string
     */
    public function getDefaultTitle(): string
    {
        $project = $this->context->getPath('project');
        $tokens = $this->getCommandTokens();

        $title = array_shift($tokens);
        $title = str_replace($project, '', $title);

        return trim($title, "/");
    }

    /**
     * Devuelve el titulo del mensaje de log
     *
     * @return string
     */
    public function getTitle(): string
    {
        if (empty($this->title)) {
            $this->title = $this->getDefaultTitle();
        }
        return $this->title;
    }


    /**
     * Devuelve la salida.
     *
     * @return string
     */
    public function getOutput(): string
    {
        return $this->output;
    }

    /**
     * Devuelve el grupo de acciones a la que pertenece este comando.
     *
     * @return string
     */
    public function getGroup(): string
    {
        return ucfirst($this->group);
    }

    /**
     * Ejecuta el comando
     *
     * @return bool
     */
    abstract public function run(): bool;
}
